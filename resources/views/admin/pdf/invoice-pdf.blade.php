
<body>
    <table class="invoice-header">
        <tr>
            <td style="width: 50%; text-align: left;">
                <h1>Invoice</h1>
                
            </td>
            <td class="business-info" style="width: 50%;">
                <h2>{{ (isset($recordInfo)  && !empty($recordInfo->profileDetails) && !empty($recordInfo->profileDetails->v_shop_name)  ? $recordInfo->profileDetails->v_shop_name : '') }}</h2>
                <p>{{ (isset($recordInfo)  && !empty($recordInfo->profileDetails) && !empty($recordInfo->profileDetails->v_address)  ? $recordInfo->profileDetails->v_address : '') }}</p>
                <p>{{ (isset($recordInfo)  && !empty($recordInfo->loginInfo) && !empty($recordInfo->loginInfo->v_mobile)  ? $recordInfo->loginInfo->v_mobile : '') }}</p>
                <p>{{ (isset($recordInfo)  && !empty($recordInfo->loginInfo) && !empty($recordInfo->loginInfo->v_email)  ? $recordInfo->loginInfo->v_email : '') }}</p>
            </td>
        </tr>
    </table>

    <table class="invoice-details">
        <tr>
            <td class="details" style="text-align: left; padding-right: 20px;">
                <h3>INVOICE DETAILS:</h3>
                <p style="line-height: 1.8;"><strong>Invoice</strong> INV-{{ (isset($recordInfo)  && !empty($recordInfo->i_id)  ? $recordInfo->i_id : '') }}</p>
                <p style="line-height: 1.8;"><strong>Date of Issue</strong> {{ (isset($recordInfo)  && !empty($recordInfo->dt_created_at)  ? clientDate($recordInfo->dt_created_at) : '') }}</p>
                <p style="line-height: 1.8;"><strong>Due Date</strong> {{ (isset($recordInfo)  && !empty($recordInfo->dt_date)  ? clientDate($recordInfo->dt_date) : '') }}</p>
            </td>   
            <td style="width: 4%;">&nbsp;</td>
            <td class="bill-to" style="text-align: right; padding-left: 20px;">
                <h3>BILL TO:</h3>
                <p style="padding-bottom: 5px;"><strong>{{ (isset($recordInfo)  && !empty($recordInfo->v_name)  ? $recordInfo->v_name : '') }}</strong></p>
                <p><strong>{{ (isset($recordInfo)  && !empty($recordInfo->v_mobile)  ? $recordInfo->v_mobile : '') }}</strong></p>
                <p>{{ (isset($recordInfo)  && !empty($recordInfo->v_address)  ? $recordInfo->v_address : '') }}</p>
            </td>
        </tr>
    </table>
    <div class="line"></div>
    <table class="service-header" style="margin-top:50px; border-collapse: collapse;">
    <thead>
        <tr>
            <th style="border: 1px solid black; padding: 10px;">SERVICE</th>
            <th style="border: 1px solid black; padding: 10px;">EVENTS</th>
            <th style="border: 1px solid black; padding: 10px;">DATE</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($services) && !empty($services))
            @foreach ($services as $index => $service)
                <tr>
                    <td style="border: 1px solid black; padding: 10px;">
                        {{ !empty($service->v_service) ? $service->v_service : '' }}
                    </td>
                    <td style="border: 1px solid black; padding: 10px;">
                        {{ isset($events[$index]) && !empty($events[$index]->v_event) ? $events[$index]->v_event : '' }}
                    </td>
                    @if ($index == 0) 
                        <td style="border: 1px solid black; padding: 10px; text-align: center;" rowspan="{{ count($services) }}">
                            {{ isset($recordInfo) && !empty($recordInfo->dt_date) ? clientDate($recordInfo->dt_date) : '' }}
                        </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
    <table class="summary" style="margin-top: 30px;">
       <tr>
        <td>
            <h3>Shop Signature & Mohar</h3>
       </td>
       <td class="totals">
           <h3><strong>Total:</strong> ₹{{ (isset($recordInfo) && !empty($recordInfo->v_total_payment) ? $recordInfo->v_total_payment : '') }}</h3>
           <h3><strong>Advance:</strong> ₹{{ (isset($recordInfo) && !empty($recordInfo->v_advance_payment) ? $recordInfo->v_advance_payment : '') }}</h3>
           <h3><strong>Total Due:</strong> ₹{{ (isset($recordInfo) && !empty($recordInfo->v_due_payment) ? $recordInfo->v_due_payment : '') }}</h3>
        </td>
    </tr>
    </table>
    <div class="footer">
        <p>{{ date('d-m-Y') }}</p>
    </div>
</body>
