<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Apnic;

class ApnicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function search(Request $request)
    {

        $data = $request->only('type','country','year','search_type');
        $total = Apnic::where('type',$data['type'])
                ->where('country',strtoupper($data['country']))
                ->where('registered_date','like', $data['year'].'%')
                ->count();

        return response()->json(['Economy' => strtoupper($data['country']),'Resource' => strtoupper($data['type']), 'Year' => $data['year'] , 'Total' => $total ]);
    }

    public function init()
    {
        echo "Connecting external resource...\r\n";
        $external_resource = file_get_contents(env('DATA_FILE'));
        $line_array = preg_split('/\n|\r\n?/', $external_resource);

        echo "Validating resource format...\r\n";
        if($line_array[18]!='# ' || $line_array[26]!='#') die('Invalid format, existing...\r\n');

        echo "Resource format is valid, updating local storage...\r\n";

        echo "Truncating local storage...\r\n";
        Apnic::truncate();

        echo "Importing...\r\n";

        for($i=31;1;$i++)
        {
            if( isset($line_array[$i]) && substr($line_array[$i], 0, 5)=='apnic' )
            {
                $data = explode('|',$line_array[$i]);
               if($i>53000) var_dump(array($i,$data));
                $apnic = new Apnic;
                $apnic->registry = $data[0];
                $apnic->country = $data[1];
                $apnic->type = $data[2];
                $apnic->data = $data[3];
                $apnic->amount = $data[4];
                $apnic->registered_date = $data[5];
                $apnic->status = $data[6];
                $apnic->save();
            }
            else
            {
                break;
            }

        }
        echo "Done, finished successfully.";
    }

}
