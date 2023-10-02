<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Service Export</title>
</head>
<body>
    <table class=" ">
        <thead>
            <tr>
                <th>
                    {{ trans('global.no') }}
                </th>
                <th>
                    {{ trans('cruds.invoice.fields.customer_name') }}
                </th>
                <th>
                    {{ trans('cruds.customerAssign.fields.township') }}
                </th>
                <th>
                    {{ trans('cruds.customerAssign.fields.address') }}
                </th>
                <th>
                    {{ trans('cruds.customerAssign.fields.service_area') }}
                </th>
                <th>
                    {{ trans('cruds.customerAssign.fields.engineer') }}
                </th>
                <th>
                    {{ trans('cruds.customerAssign.fields.service_date') }}
                </th>
                <th>
                    {{ trans('cruds.invoice.fields.remark') }}
                </th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @foreach ($invoices as $key => $invoice)
                <tr data-entry-id="{{ $invoice->id }}">
                    <td>
                        {{ $loop->iteration  }}
                    </td>
                    <td>
                        {{ $invoice->customer_name->name }}
                    </td>
                    <td>
                        {{ $invoice->customerAssign->township ?? '-' }}
                    </td>
                    <td>
                        {{ $invoice->customerAssign->address ?? '-' }}
                    </td>
                    <td>
                        {{ $invoice->customerAssign->service_area }}
                    </td>
                    <td>
                        {{ $invoice->customerAssign->service_person->name }}
                    </td>
                    <td>
                        {{ $invoice->issue_date ? date('d/m/Y', strtotime($invoice->issue_date)) : '' }}
                    </td>
                    <td>
                        {{ $invoice->remark ?? ''}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
