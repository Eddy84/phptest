<?php

namespace App\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

use App\Models\Trade;
use App\Models\User;
use DB;
use Validator;

use Carbon\Carbon;

class TradesController extends BaseController
{
    use ValidatesRequests;


    public function erase(Request $request)
    {
        Trade::query()->delete();

        // disable foreign key constraints
        // Trade::truncate();

        return response()->json(['message'=>'all trades erased'],200);
    }
    public function newTrade(Request $request)
    {
        $json = $request->json()->all();

        $validator = Validator::make($request->json()->all(),
            [
                'id'        => 'required|integer',
                'type'      => 'required|in:buy,sell',
                'user'      => 'required|array',
                'user.id'   => 'required|integer',
                'user.name' => 'required|string',
                'symbol'    => 'required|string',
                'shares'    => 'required|integer',
                'price'     => 'required|numeric',
                'timestamp' => 'required|date'
            ]);

            if($validator->fails())
            {
                return response()->json(['message'=>"invalid trade payload",'validation'=>$validator->errors()],400);
            }

        $trade = Trade::find($json['id']);
        if($trade != null)
        {
            return response()->json(['message'=>'trade already exists'],400);
        }

        $tradeNew = new Trade();
        $tradeNew->fill($json);
        $tradeNew->userId = $json['user']['id'];
        $tradeNew->save();

        return response()->json(['message'=>"trade created"],201);
    }
    public function getTrades(Request $request)
    {
        $trades = Trade::query()->orderBy('id','ASC')->get();

        return response()->json(['trades'=>$trades->toArray()],200);
    }
    public function getTradesByUserId(Request $request,$userId)
    {
        $user = User::find($userId);
        if($user == null)
        {
            return response()->json(['message'=>'user not found'],404);
        }
        else
        {
            $trades = Trade::where('userId','=',$userId)->orderBy('id','ASC')->get();

            return response()->json(['trades'=>$trades->toArray()],200);
        }

    }
    public function getStockSymbolPrices(Request $request,$stockSymbol)
    {
        $validator = Validator::make($request->all(),
            [
                'start' => 'required|date',
                'end'   => 'required|date'
            ]);

        if($validator->fails())
        {
            return response()->json(['message'=>'validation failed','validation'=>$validator->errors()],400);
        }

        if(Trade::where('symbol','=',$stockSymbol)->count() == 0)
        {
            return response()->json(['message'=>'symbol not found'],404);
        }

        $dateStart = Carbon::parse($request->get('start'));
        $dateEnd = Carbon::parse($request->get('end'));

        $res = Trade::select(DB::raw('min(price) lowest, max(price) highest'))
            ->where('symbol','=',$stockSymbol)
            ->where('timestamp','>',$dateStart)
            ->where('timestamp','<',$dateEnd)
            ->first();

        if($res->lowest == null || $res->highest == null)
        {
            return response()->json(['message'=>'There are no trades in the given date range'],200);
        }
        else
        {
            $lowest = (float)$res->lowest;
            $highest = (float)$res->highest;

            return response()->json(['symbol'=>$stockSymbol,'lowsest'=>$lowest,'highest'=>$highest],200);
        }
    }
    public function getStockStats(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'start' => 'required|date',
            'end'   => 'required|date'
        ]);

        if($validator->fails())
        {
            return response()->json(['message'=>'validation failed','validation'=>$validator->errors()],400);
        }

        $dateStart = Carbon::parse($request->get('start'));
        $dateEnd = Carbon::parse($request->get('end'));

        $symbols = Trade::select(DB::raw('symbol'))
            ->where('timestamp','>',$dateStart)
            ->where('timestamp','<',$dateEnd)
            ->groupBy('symbol')
            ->get()
            ->map(function($trade) { return $trade->symbol; });

        $items = [];
        foreach($symbols as $symbol)
        {
            $trades = Trade::where('symbol','=',$symbol)
            ->where('timestamp','>',$dateStart)
            ->where('timestamp','<',$dateEnd)
            ->get();

            if(count($trades) < 3)
            {
                $items[] =
                [
                    "stock"     => $symbol,
                    "message"   => "There are no trades in the given date range",
                ];
            }
            else
            {
                $item = $this->evaluateFluctuations($trades);
                $item["stock"] = $symbol;

                $items[] = $item;
            }
        }

        return response()->json($items,200);
    }

    protected function evaluateFluctuations($trades)
    {
        $fluctuations = 0;
        $max_fall = 0;
        $max_rise = 0;

        for($i=0;$i<count($trades)-2;++$i)
        {
            $a = $trades[$i];
            $b = $trades[$i+1];
            $c = $trades[$i+2];

            if($a->price < $b->price && $b->price > $c->price) { ++$fluctuations; }
            if($a->price > $b->price && $b->price < $c->price) { ++$fluctuations; }
        }

        for($i=0;$i<count($trades)-1;++$i)
        {
            $a = $trades[$i];
            $b = $trades[$i+1];

            if($a->price > $b->price) { $max_fall = max($max_fall,$a->price - $b->price); }
            if($a->price < $b->price) { $max_rise = max($max_rise,$b->price - $a->price); }
        }

        return ['fluctuations'=>$fluctuations,'max_fall'=>$max_fall,'max_rise'=>$max_rise];
    }
}
