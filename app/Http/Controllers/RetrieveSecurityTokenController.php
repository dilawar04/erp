<?php

namespace App\Http\Controllers;

use App\BlogPost;
use Illuminate\Http\Request;

class RetrieveSecurityTokenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    public function index()
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://srn.app.radixx.com/SRN/Radixx.ConnectPoint/ConnectPoint.Security.svc',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
            <Body>
                <RetrieveSecurityToken xmlns="http://tempuri.org/">
                    <!-- Optional -->
                    <RetrieveSecurityTokenRequest>
                        <CarrierCodes xmlns="http://schemas.datacontract.org/2004/07/Radixx.ConnectPoint.Request">
                            <!-- Optional -->
                            <CarrierCode>
                                <AccessibleCarrierCode>ER</AccessibleCarrierCode>
                            </CarrierCode>
                        </CarrierCodes>
                        <LogonID xmlns="http://schemas.datacontract.org/2004/07/Radixx.ConnectPoint.Security.Request">CHALOJE_ER_P</LogonID>
                        <Password xmlns="http://schemas.datacontract.org/2004/07/Radixx.ConnectPoint.Security.Request">RGO$PRD!</Password>
                    </RetrieveSecurityTokenRequest>
                </RetrieveSecurityToken>
            </Body>
        </Envelope>',
          CURLOPT_HTTPHEADER => array(
            'SOAPAction: http://tempuri.org/IConnectPoint_Security/RetrieveSecurityToken',
            'Content-Type: text/xml'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        // echo $response;
        // echo '<br>';
        echo '<h3>RetrieveSecurityToken: <span>';
        echo substr($response,707);
        echo '</span></h3>';
        
        
        

    }

   

}
