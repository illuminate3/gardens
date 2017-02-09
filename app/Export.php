<?php

namespace App;

class Export
{
    public function export($fields, $data, $name='Export')
    {
        $filename = "attachment; filename=\"". time() . '-' .$name.".csv\"";
        


        $output='';
        while (list($key, $value) =each($fields)) {
            $output.=$key.",";
        }

        $output.="\n";
        foreach ($data as $row) {
            reset($fields);
            while (list($key, $field) =each($fields)) {
                if (is_array($field)) {
                    $subrow = $row->$key;
                    
                    while (list($subkey, $subvalue)=each($field)) {
                        if (isset($subrow[0])) {
                            $output.=str_replace(",", " ", strip_tags($subrow[0]->$subvalue))."~";
                        }
                    }
                    $output = substr($output, 0, -1);
                    $output.=",";
                } else {
                    $output.=str_replace(",", " ", strip_tags($row->$key)).",";
                }
            }
            $output.="\n";
        }

        $headers = array(
              'Content-Type' => 'text/csv',
              'Content-Disposition' => $filename ,
          );
        $results['headers'] = $headers;
        $results['output'] = $output;
    
        return $results;
    }
}
