<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Site Information</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th class="text-wrap" align="center" colspan="13">Customer Information</th>
                <th class="text-wrap" align="center" colspan="14">Installation Information</th>
                <th class="text-wrap" align="center" colspan="21">Installation Materials Usage</th>
                <th class="text-wrap" align="center" colspan="13">Remark</th>
            </tr>
            <tr>
                <!-- Customer Information -->
                <th class="text-wrap" align="center">Ticket No</th>
                <th class="text-wrap" align="center">User ID</th>
                <th class="text-wrap" align="center">Service Plan</th>
                <th class="text-wrap" align="center">Bandwidth(Mbps)</th>
                <th class="text-wrap" align="center">Register Date</th>
                <th class="text-wrap" align="center">Sales Voucher No.</th>
                <th class="text-wrap" align="center">Account User Name</th>
                <th class="text-wrap" align="center">Contact Person Name</th>
                <th class="text-wrap" align="center">Installation Address</th>
                <th class="text-wrap" align="center">Township</th>
                <th class="text-wrap" align="center">Mobile Phone</th>
                <th class="text-wrap" align="center">Customer (Lat)</th>
                <th class="text-wrap" align="center">Customer (Long)</th>
                <!-- Installation Information -->
                <th class="text-wrap" align="center">OBD No.</th>
                <th class="text-wrap" align="center">OBD (Lat)</th>
                <th class="text-wrap" align="center">OBD (Long)</th>
                <th class="text-wrap" align="center">OBD Splitter No.</th>
                <th class="text-wrap" align="center">OBD Splitter Pair No.</th>
                <th class="text-wrap" align="center">ONT Received Power dBm</th>
                <th class="text-wrap" align="center">OLT Name</th>
                <th class="text-wrap" align="center">Installation Assigned Date</th>
                <th class="text-wrap" align="center">Installation Finished Date</th>
                <th class="text-wrap" align="center">Assign Team</th>
                <th class="text-wrap" align="center">Installation Engineer</th>
                <th class="text-wrap" align="center">Installation Status</th>
                <th class="text-wrap" align="center">Resolution</th>
                <!-- Installation Materials Usage -->
                <th class="text-wrap" align="center">Drop Cable Length(Meter)</th>
                <th class="text-wrap" align="center">Start Meter</th>
                <th class="text-wrap" align="center">End Meter</th>
                <th class="text-wrap" align="center">Cable Drum No.</th>
                <th class="text-wrap" align="center">Drop Sleeve (Pcs)</th>
                <th class="text-wrap" align="center">1 Core JC/ Sleeve Holder(Pcs)</th>
                <th class="text-wrap" align="center">Patch Cord</th>
                {{-- <th class="text-wrap" align="center">Patch Cord(SC/UPC-SC/UPC-1M)</th>
                <th class="text-wrap" align="center">Patch Cord(SC/UPC-SC/APC-3M)</th>
                <th class="text-wrap" align="center">Patch Cord(SC/UPC-SC/APC-1M)</th> --}}
                <th class="text-wrap" align="center">Cable Ties(Pcs)</th>
                <th class="text-wrap" align="center">Label Tape(Roll)</th>
                <th class="text-wrap" align="center">ONU Sticker</th>
                <th class="text-wrap" align="center">Customer Acceptance Form</th>
                <th class="text-wrap" align="center">ONU Type</th>
                <th class="text-wrap" align="center">ONU Model No.</th>
                <th class="text-wrap" align="center">ONT Serial No.</th>
                <th class="text-wrap" align="center">ONU (NEW Dual Bnd/New/CPE)</th>
                <th class="text-wrap" align="center">Amount (MMK) Plan</th>
                <th class="text-wrap" align="center">Received Total Amount (MMK)</th>
                <th class="text-wrap" align="center">Amount Received Date</th>
                <!-- Remark -->
                <th class="text-wrap" align="center">Sale Person Remark</th>
                <th class="text-wrap" align="center">Installation Remark</th>
            </tr>
        </thead>
        <tbody>
        {{-- @dd($invoices); --}}
        @foreach($invoices  as $invoice)
            <tr>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['ticket_no']}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['customer_code'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['service_plan']['service_plan'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['bandwidth'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['register_date'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['sales_voucher_no'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['name']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['contact_person']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['address']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['township']['township'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['phone_number']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['site_lat']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_name']['site_long']  ?? '-'}}</td>
                <!-- Installation Information -->
                <td class="text-wrap" align="center">{{$invoice['odb_no']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['odb_lat']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['odb_long']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['odb_splitter_no'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['odb_splitter_pair_no'] ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['ont_received_power']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['olt_name']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['assign_date']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['finished_date']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['assign_team']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['service_person']['name'] ?? ''  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['invoice_status']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['resolution']  ?? '-'}}</td>
                <!-- Installation Materials Usage -->
                <td class="text-wrap" align="center">{{$invoice['drop_cable_length']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['start_meter']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['end_meter']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['cable_drum_no']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['drop_sleeve_pcs']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['core_jc_sleeve_holder_pcs']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['patch_cord']??''  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['cable_tiles_pcs']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['label_tape_rol']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['onu_sticker']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['customer_acceptance_form']  ?? '-'}}</td>
                <td class="text-wrap" align="center">
                    @foreach($invoice['products'] as $p)
                    {{$p['onu_type']  ?? '-'}},
                    @endforeach
                </td>
                <td class="text-wrap" align="center">
                    @foreach($invoice['products'] as $p)
                    {{$p['onu_model_no']  ?? '-'}},
                    @endforeach
                </td>
                <td class="text-wrap" align="center">
                    @foreach($invoice['products'] as $p)
                    {{$p['ont_serial_no']  ?? '-'}},
                    @endforeach
                </td>
                <td class="text-wrap" align="center">
                    @foreach($invoice['products'] as $p)
                    {{App\Models\Product::ONU_LISTS[$p['onu_type']  ?? '-']}},
                    @endforeach
                </td>
                <td class="text-wrap" align="center">{{$invoice['total']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['received_total_amount']  ?? '-'}}</td>
                <td class="text-wrap" align="center">{{$invoice['received_date']  ?? '-'}}</td>
                <!-- Remark -->
                <th class="text-wrap" align="center">{{$invoice['sale_person_remark'] ?? '-'}}</th>
                <th class="text-wrap" align="center">I{{$invoice['received_date'] ?? '-'}}</th>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
