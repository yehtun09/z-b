@extends('layouts.admin')
{{-- dropzone-style --}}
@section('styles')
<style>
    .dropzone-wrapper {
    border: 2px dashed #91b0b3;
    color: #92b0b3;
    cursor: pointer;
    position: relative;
    height: 150px;
    background-size: auto 130px;
    }

    .preview-img{
        width: 100%;
        height: 150px;
        position: relative;
        background-size: auto 130px;
    }

    .dropzone-desc {
    position: absolute;
    margin: 0 auto;
    left: 0;
    right: 0;
    text-align: center;
    width: 40%;
    top: 50px;
    font-size: 16px;
    }

    .dropzone,
    .dropzone:focus {
    position: absolute;
    outline: none !important;
    width: 100%;
    height: 150px;
    cursor: pointer;
    opacity: 0;
    }

    .dropzone-wrapper:hover,
    .dropzone-wrapper.dragover {
    background: #ecf0f5;
    }
</style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.invoice.title_singular') }}
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('admin.invoices.update',$invoice->id) }}" enctype="multipart/form-data" id="myForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <input type="hidden" id="invoice_id" value="{{ $invoice->id }}">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="customer_name_id">{{ trans('cruds.invoice.fields.customer_name') }}</label>
                            <select readonly  class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" name="customer_name_id" id="customer_name_id" required>
                                @foreach($customer_names as $id => $entry)
                                <option value="{{ $id }}" {{ old('customer_name_id',$invoice->customer_name_id) == $id ? 'selected' : 'disabled' }}>
                                    {{ $entry }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('customer_name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('customer_name') }}
                            </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.customer_name_helper') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="odb_lat">{{ trans('cruds.invoice.fields.odb_lat') }}</label>
                            <input class="form-control {{ $errors->has('odb_lat') ? 'is-invalid' : '' }}" type="text"
                                name="odb_lat" id="odb_lat" value="{{ old('odb_lat', $invoice->odb_lat) }}" required>
                            @if ($errors->has('odb_lat'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('odb_lat') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.odb_lat_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="odb_long">{{ trans('cruds.invoice.fields.odb_long') }}</label>
                            <input class="form-control {{ $errors->has('odb_long') ? 'is-invalid' : '' }}" type="text"
                                name="odb_long" id="odb_long" value="{{ old('odb_long', $invoice->odb_long) }}" required>
                            @if ($errors->has('odb_long'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('odb_long') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.odb_long_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="odb_no">{{ trans('cruds.invoice.fields.odb_no') }}</label>
                            <input class="form-control {{ $errors->has('odb_no') ? 'is-invalid' : '' }}" type="text"
                                name="odb_no" id="odb_no" value="{{ old('odb_no', $invoice->odb_no) }}" required>
                            @if ($errors->has('odb_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('odb_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.odb_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="odb_splitter_no">{{ trans('cruds.invoice.fields.odb_splitter_no') }}</label>
                            <input class="form-control {{ $errors->has('odb_splitter_no') ? 'is-invalid' : '' }}" type="text"
                                name="odb_splitter_no" id="odb_splitter_no" value="{{ old('odb_splitter_no', $invoice->odb_splitter_no) }}" required>
                            @if ($errors->has('odb_splitter_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('odb_splitter_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.odb_splitter_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="odb_splitter_pair_no">{{ trans('cruds.invoice.fields.odb_splitter_pair_no') }}</label>
                            <input class="form-control {{ $errors->has('odb_splitter_pair_no') ? 'is-invalid' : '' }}" type="text"
                                name="odb_splitter_pair_no" id="odb_splitter_pair_no" value="{{ old('odb_splitter_pair_no', $invoice->odb_splitter_pair_no) }}" required>
                            @if ($errors->has('odb_splitter_pair_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('odb_splitter_pair_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.odb_splitter_pair_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="ont_received_power">{{ trans('cruds.invoice.fields.ont_received_power') }}</label>
                            <input class="form-control {{ $errors->has('ont_received_power') ? 'is-invalid' : '' }}" type="text"
                                name="ont_received_power" id="ont_received_power" value="{{ old('ont_received_power', $invoice->ont_received_power) }}" readonly required>
                            @if ($errors->has('ont_received_power'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('ont_received_power') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.ont_received_power_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="olt_name">{{ trans('cruds.invoice.fields.olt_name') }}</label>
                            <input class="form-control {{ $errors->has('olt_name') ? 'is-invalid' : '' }}" type="text"
                                name="olt_name" id="olt_name" value="{{ old('olt_name', $invoice->olt_name) }}" readonly required>
                            @if ($errors->has('olt_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('olt_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.olt_name_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="assign_team">{{ trans('cruds.invoice.fields.assign_team') }}</label>
                            <input class="form-control {{ $errors->has('assign_team') ? 'is-invalid' : '' }}" type="text"
                                name="assign_team" id="assign_team" value="{{ old('assign_team', $invoice->assign_team) }}" readonly required>
                            @if ($errors->has('assign_team'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('assign_team') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.assign_team_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="installation_period">{{ trans('cruds.invoice.fields.installation_period') }}</label>
                            <input class="form-control {{ $errors->has('installation_period') ? 'is-invalid' : '' }}" type="text"
                                name="installation_period" id="installation_period" readonly value="{{ old('installation_period', $invoice->installation_period) }}">
                            @if ($errors->has('installation_period'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('installation_period') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.installation_period_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="resolution">{{ trans('cruds.invoice.fields.resolution') }}</label>
                            <input class="form-control {{ $errors->has('resolution') ? 'is-invalid' : '' }}" type="text"
                                name="resolution" id="resolution" value="{{ old('resolution', $invoice->resolution) }}" readonly>
                            @if ($errors->has('resolution'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('resolution') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.resolution_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="cable_drum_no">{{ trans('cruds.invoice.fields.cable_drum_no') }}</label>
                            <input class="form-control {{ $errors->has('cable_drum_no') ? 'is-invalid' : '' }}" type="number"
                                name="cable_drum_no" id="cable_drum_no" value="{{ old('cable_drum_no', $invoice->cable_drum_no) }}" required>
                            @if ($errors->has('cable_drum_no'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cable_drum_no') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.cable_drum_no_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="start_meter">{{ trans('cruds.invoice.fields.start_meter') }}</label>
                            <input class="form-control {{ $errors->has('start_meter') ? 'is-invalid' : '' }}" type="number"
                                name="start_meter" id="start_meter" value="{{ old('start_meter', $invoice->start_meter) }}" required>
                            @if ($errors->has('start_meter'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('start_meter') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.start_meter_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="end_meter">{{ trans('cruds.invoice.fields.end_meter') }}</label>
                            <input class="form-control {{ $errors->has('end_meter') ? 'is-invalid' : '' }}" type="number"
                                name="end_meter" id="end_meter" value="{{ old('end_meter', $invoice->end_meter) }}" required>
                            @if ($errors->has('end_meter'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('end_meter') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.end_meter_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="drop_cable_length">{{ trans('cruds.invoice.fields.drop_cable_length') }}</label>
                            <input class="form-control {{ $errors->has('drop_cable_length') ? 'is-invalid' : '' }}" type="number"
                                name="drop_cable_length" id="drop_cable_length" value="{{ old('drop_cable_length', $invoice->drop_cable_length) }}" required>
                            @if ($errors->has('drop_cable_length'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('drop_cable_length') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.drop_cable_length_helper') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="drop_sleeve_pcs">{{ trans('cruds.invoice.fields.drop_sleeve_pcs') }}</label>
                            <input class="form-control {{ $errors->has('drop_sleeve_pcs') ? 'is-invalid' : '' }}" type="number"
                                name="drop_sleeve_pcs" id="drop_sleeve_pcs" value="{{ old('drop_sleeve_pcs', $invoice->drop_sleeve_pcs) }}" required>
                            @if ($errors->has('drop_sleeve_pcs'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('drop_sleeve_pcs') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.drop_sleeve_pcs_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="core_jc_sleeve_holder_pcs">{{ trans('cruds.invoice.fields.core_jc_sleeve_holder_pcs') }}</label>
                            <input class="form-control {{ $errors->has('core_jc_sleeve_holder_pcs') ? 'is-invalid' : '' }}" type="number"
                                name="core_jc_sleeve_holder_pcs" id="core_jc_sleeve_holder_pcs" value="{{ old('core_jc_sleeve_holder_pcs', $invoice->core_jc_sleeve_holder_pcs) }}" required>
                            @if ($errors->has('core_jc_sleeve_holder_pcs'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('core_jc_sleeve_holder_pcs') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.core_jc_sleeve_holder_pcs_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="patch_cord">{{ trans('cruds.invoice.fields.patch_cord') }}</label>
                            <select class="form-control {{ $errors->has('patch_cord') ? 'is-invalid' : '' }}" name="patch_cord" id="patch_cord">
                                <option value="">{{trans('global.pleaseSelect')}}</option>
                                @foreach (App\Models\Invoice::PATCH_CORD_TYPE as $key=>$value )
                                    <option value="{{$key}}" {{old('patch_cord',$invoice->patch_cord) == $key ? 'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('patch_cord'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('patch_cord') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.patch_cord_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="cable_tiles_pcs">{{ trans('cruds.invoice.fields.cable_tiles_pcs') }}</label>
                            <input class="form-control {{ $errors->has('cable_tiles_pcs') ? 'is-invalid' : '' }}" type="text"
                                name="cable_tiles_pcs" id="cable_tiles_pcs" value="{{ old('cable_tiles_pcs', $invoice->cable_tiles_pcs) }}">
                            @if ($errors->has('cable_tiles_pcs'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('cable_tiles_pcs') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.cable_tiles_pcs_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="label_tape_rol">{{ trans('cruds.invoice.fields.label_tape_rol') }}</label>
                            <input class="form-control {{ $errors->has('label_tape_rol') ? 'is-invalid' : '' }}" type="text"
                                name="label_tape_rol" id="label_tape_rol" value="{{ old('label_tape_rol', $invoice->label_tape_rol) }}">
                            @if ($errors->has('label_tape_rol'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('label_tape_rol') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.label_tape_rol_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="onu_sticker">{{ trans('cruds.invoice.fields.onu_sticker') }}</label>
                            <input class="form-control {{ $errors->has('onu_sticker') ? 'is-invalid' : '' }}" type="text"
                                name="onu_sticker" id="onu_sticker" value="{{ old('onu_sticker', $invoice->onu_sticker) }}" >
                            @if ($errors->has('onu_sticker'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('onu_sticker') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.onu_sticker_helper') }}</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="customer_acceptance_form">{{ trans('cruds.invoice.fields.customer_acceptance_form') }}</label>
                            <input class="form-control {{ $errors->has('customer_acceptance_form') ? 'is-invalid' : '' }}" type="text"
                                name="customer_acceptance_form" id="customer_acceptance_form" value="{{ old('customer_acceptance_form', $invoice->customer_acceptance_form) }}" >
                            @if ($errors->has('customer_acceptance_form'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('customer_acceptance_form') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.customer_acceptance_form_helper') }}</span>
                        </div>
                    </div>
                    
                 
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="update_status">{{ trans('cruds.invoice.fields.update_status') }}</label>
                            <div class="row">
                                @foreach(App\Models\Invoice::INVOICE_STATUS_RADIO as $key => $value)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input {{ $errors->has('update_status') ? 'is-invalid' : '' }}" type="radio" name="update_status" id="update_status_{{$key}}" value="{{$key}}" {{$key==$invoice->update_status ? 'checked':''}}>
                                            <label class="form-check-label" for="update_status_{{$key}}">
                                              {{$value}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                                
                            </div>
                            
                            @if ($errors->has('update_status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('update_status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.update_status_helper') }}</span>
                        </div>
                    </div>
                    
                   
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="sale_person_remark">{{ trans('cruds.invoice.fields.sale_person_remark') }}</label>
                            <textarea rows="1" name="sale_person_remark" id="sale_person_remark" class="form-control {{ $errors->has('sale_person_remark') ? 'is-invalid' : '' }}" rows="3">{{ old('sale_person_remark', $invoice->sale_person_remark) }}</textarea>
                            @if ($errors->has('sale_person_remark'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sale_person_remark') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.sale_person_remark_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="" for="installation_remark">{{ trans('cruds.invoice.fields.installation_remark') }}</label>
                            <textarea rows="1" name="installation_remark" id="installation_remark" class="form-control {{ $errors->has('installation_remark') ? 'is-invalid' : '' }}" rows="3">{{ old('installation_remark', $invoice->installation_remark) }}</textarea>
                            @if ($errors->has('installation_remark'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('installation_remark') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.installation_remark_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="issue_date">{{ trans('cruds.invoice.fields.issue_date') }}</label>
                            <input class="form-control {{ $errors->has('issue_date') ? 'is-invalid' : '' }}" type="text"
                                name="issue_date" id="issue_date" placeholder="YYYY-MM-DD" value="{{ old('issue_date', $invoice->issue_date) }}" required>
                            @if ($errors->has('issue_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('issue_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.issue_date_helper') }}</span>
                        </div>
                    </div>
                    @if(auth()->user()->is_admin || auth()->user()->is_administrator)
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="assign_date">{{ trans('cruds.invoice.fields.assign_date') }}</label>
                            <input class="form-control {{ $errors->has('assign_date') ? 'is-invalid' : '' }}" type="text"
                                name="assign_date" id="assign_date" placeholder="YYYY-MM-DD" value="{{ old('assign_date', $invoice->assign_date) }}" required>
                            @if ($errors->has('assign_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('assign_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.assign_date_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="suspend_date">{{ trans('cruds.invoice.fields.suspend_date') }}</label>
                            <input class="form-control {{ $errors->has('suspend_date') ? 'is-invalid' : '' }}" type="text"
                                name="suspend_date" id="suspend_date" placeholder="YYYY-MM-DD" value="{{ old('suspend_date', $invoice->suspend_date) }}" required>
                            @if ($errors->has('suspend_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('suspend_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.suspend_date_helper') }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="finished_date">{{ trans('cruds.invoice.fields.finished_date') }}</label>
                            <input class="form-control {{ $errors->has('finished_date') ? 'is-invalid' : '' }}" type="text"
                                name="finished_date" id="finished_date" placeholder="YYYY-MM-DD" value="{{ old('finished_date', $invoice->finished_date) }}" required>
                            @if ($errors->has('finished_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('finished_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.finished_date_helper') }}</span>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="required" for="received_date">{{ trans('cruds.invoice.fields.received_date') }}</label>
                            <input class="form-control {{ $errors->has('received_date') ? 'is-invalid' : '' }}" type="text"
                                name="received_date" id="received_date" placeholder="YYYY-MM-DD" value="{{ old('received_date', $invoice->received_date) }}" required>
                            @if ($errors->has('received_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('received_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.received_date_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-5">
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.invoice.fields.odp1') }}</label>
                            <input type="file" name="odp1" class="imagefile" data-id="odp1" id="file-odp1" hidden>
                            {{-- @php 
                                $data = [];
                                 foreach($invoice->media as $key => $media){
                                    if(in_array($media->collection_name, ['odp1'])){
                                        
                                    }
                                 }
                                           
                            @endphp --}}
                            <div class="dropzone-wrapper" id="odp1" >
                                <div class="preview-img" id="odp1-preview" style="background-image: url('{{ $invoice->getFirstMedia('odp1') ? $invoice->getFirstMedia('odp1')->getUrl('preview') : '' }}'); background-repeat: no-repeat; background-position: center;background-size: auto 130px;"></div>
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    {{-- image exist check --}}
                                    @if($invoice->getFirstMedia('odp1'))
                                        <p></p>
                                    @else   
                                        <p>Choose an image file or drag it here.</p>
                                    @endif
                                </div>
                            </div>
                            {{-- <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                            </div> --}}
                            {{-- @if($errors->has('images'))
                                <span class="text-danger">{{ $errors->first('images') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.images_helper') }}</span> --}}
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.invoice.fields.odp2') }} </label>
                            <input type="file" name="odp2" class="imagefile" data-id="odp2" id="file-odp2" hidden>
                            <div class="dropzone-wrapper" id="odp2">
                                <div class="preview-img" id="odp2-preview" style="background-image: url('{{ $invoice->getFirstMedia('odp2') ? $invoice->getFirstMedia('odp2')->getUrl('preview') : '' }}'); background-repeat: no-repeat; background-position: center;background-size: auto 130px;"></div>
                                <div class="dropzone-desc">
                                    {{-- image exist check --}}
                                    @if($invoice->getFirstMedia('odp2'))
                                        <p></p>
                                    @else   
                                        <p>Choose an image file or drag it here.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.invoice.fields.odp3') }} </label>
                            <input type="file" name="odp3" class="imagefile" data-id="odp3" id="file-odp3" hidden>
                            <div class="dropzone-wrapper" id="odp3">
                                <div class="preview-img" id="odp3-preview" style="background-image: url('{{ $invoice->getFirstMedia('odp3') ? $invoice->getFirstMedia('odp3')->getUrl('preview') : '' }}'); background-repeat: no-repeat; background-position: center; background-size: auto 130px;"></div>
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    {{-- image exist check --}}
                                    @if($invoice->getFirstMedia('odp3'))
                                        <p></p>
                                    @else   
                                        <p>Choose an image file or drag it here.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.invoice.fields.onu') }}</label>
                            <input type="file" name="onu" class="imagefile" data-id="onu" id="file-onu" hidden>
                            <div class="dropzone-wrapper" id="onu">
                                <div class="preview-img" id="onu-preview" style="background-image: url('{{ $invoice->getFirstMedia('onu') ? $invoice->getFirstMedia('onu')->getUrl('preview') : '' }}'); background-repeat: no-repeat; background-position: center;background-size: auto 130px;"></div>
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    {{-- image exist check --}}
                                    @if($invoice->getFirstMedia('onu'))
                                        <p></p>
                                    @else   
                                        <p>Choose an image file or drag it here.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mt-5">
                        <div class="form-group">
                            <label for="images">{{ trans('cruds.invoice.fields.onu') }}</label>
                            <input type="file" name="ssr" class="imagefile" data-id="ssr" id="file-ssr" hidden>
                            <div class="dropzone-wrapper" id="ssr">
                                <div class="preview-img" id="ssr-preview" style="background-image: url('{{ $invoice->getFirstMedia('ssr') ? $invoice->getFirstMedia('ssr')->getUrl('preview') : '' }}'); background-repeat: no-repeat; background-position: center;background-size: auto 130px;"></div>
                                <div class="dropzone-desc">
                                    <i class="glyphicon glyphicon-download-alt"></i>
                                    {{-- image exist check --}}
                                    @if($invoice->getFirstMedia('ssr'))
                                        <p></p>
                                    @else   
                                        <p>Choose an image file or drag it here.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="col-md-12">
                    <div class="form-group">
                        <label for="images">{{ trans('cruds.invoice.fields.images') }} <span style="color:red;font-size:0.8rem;">(Maximum 4 images)</span></label>
                        <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                        </div>
                        @if($errors->has('images'))
                            <span class="text-danger">{{ $errors->first('images') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.invoice.fields.images_helper') }}</span>
                    </div>
                </div> --}}
                <hr class="mt-4 mx-n4" />
                <div id="content">
                    <div class="source-item py-sm-3">
                        <div class="" data-repeater-list="group-a">
                            <div class="repeater-wrapper pt-0 " data-repeater-item id="container">
                                @if(count($invoice->products) != 0)
                                @foreach ($invoice->products as $product)
                                    <div class="d-flex rounded position-relative pe-0 product-count"
                                        id="product{{ $product->id }}">
                                        <div class="row w-100 m-0 p-3">
                                            
                                            <div class="col-md-6 col-12 mb-md-0 ps-md-0">
                                                <p class="mb-2 repeater-title">Product</p>
                                                <select
                                                    class="form-select product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}"
                                                    name="product_name_id0"
                                                    data-product-id="{{ $product->pivot->product_id }}"
                                                    id="product_name{{ $product->id }}" required disabled>
                                                    @foreach ($product_names as $id => $entry)
                                                        <option value="{{ $id }}"
                                                            {{ old('product_name_id') == $id ? 'selected' : '' }}
                                                            @if ($id == $product->pivot->product_id) selected @endif>
                                                            {{ $entry }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0">
                                                <p class="mb-2 repeater-title">Sales Price</p>
                                                <input type="text" style="text-align:right" name=""
                                                    class="form-control unit_price" id="unit_price{{ $product->id }}"
                                                    value="{{ (int) $product->price }}"
                                                    data-unit-price="{{ $product->price }}" disabled>
                                            </div>
                                            <div class="col-md-2 col-12 mb-md-0">
                                                <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}
                                                </p>
                                                <input type="number" style="text-align:right" name=""
                                                    class="form-control qty" id="qty{{ $product->id }}"
                                                    value="{{ $product->pivot->qty }}"
                                                    data-qty="{{ $product->pivot->qty }}" min="1" disabled>
                                                <input type="hidden" id="max{{ $product->id }}"
                                                    value="{{ $product->stock_qty }}">
                                            </div>
                                            <div class="col-md-2 col-12 pe-0">
                                                <div class="d-flex justify-content-between">
                                                    <p class="mb-2 repeater-title">
                                                        {{ trans('cruds.invoice.fields.unit_total') }}
                                                    </p>
                                                    <div class="mx-auto me-0">
                                                        <a class="btn px-0 me-1 py-0 edit " id="{{ $product->id }}" data-edit="0">
                                                            <i class="bx bxs-edit fs-5 text-secondary cursor-pointer" title="edit each particular" ></i>
                                                        </a>
                                                        <a class="btn px-0 me-1 py-0 save" id="{{ $product->id }}" data-edit="0">
                                                            <i class="bx bxs-check-circle fs-5 text-success cursor-pointer" title="save each particular" ></i>
                                                        </a>
                                                    </div>
                                                </div>
                                                <input type="text" style="text-align:right" name=""
                                                    class="form-control total unit_total" id="total{{ $product->id }}"
                                                    value="{{ $product->pivot->total }}"
                                                    data-total="{{ $product->pivot->total }}" disabled>
                                            </div>
                                            
                                        </div>
                                        <div
                                            class="d-flex flex-column align-items-start justify-content-between px-2" style="padding-top:2.6rem;padding-bottom:1rem;">
                                            <a class="btn px-0 me-1 py-0 addProduct">
                                                <i class="bx bx-plus fs-4 text-primary cursor-pointer"></i>
                                            </a>

                                            <a class="btn px-0 me-1 py-0 deleteProduct" id="{{ $product->id }}" data-delete="1">
                                                <i class="bx bx-minus fs-4 text-danger cursor-pointer" ></i>
                                            </a>
                                        </div>

                                    </div>
                                @endforeach
                                @else
                                <div class="d-flex rounded position-relative pe-0" id="row0">
                                    <div class="row w-100 m-0 p-3">
                                        <div class="col-md-6 col-12 mb-md-0 ps-md-0">
                                            <p class="mb-2 repeater-title">Product</p>
                                            <select class="form-control select2 add_product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="add_product_name0" id="add_product_name0" required>
                                            @foreach ($product_names as $id => $entry)
                                                    
                                                <option value="{{ $id }}" {{ old('product_name0') == $id ? 'selected' : '' }}>
                                                {{ $entry }}
                                                </option>
                                            
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-12 mb-md-0">
                                            <p class="mb-2 repeater-title">Sales Price</p>
                                            <input type="text" style="text-align:right" name="" class="form-control unit_price" id="add_unit_price0" value="0" disabled>
                                        </div>
                                        <div class="col-md-2 col-12 mb-md-0">
                                            <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}</p>
                                            <input type="number" style="text-align:right" name="add_qty0" class="form-control qty add_qty" id="add_qty0" value="0" min="1">
                                            <input type="hidden" id="add_max0" value="0">
                                            </div>
                                        <div class="col-md-2 col-12 pe-0">
                                            <div class="d-flex justify-content-between">
                                                    <p class="mb-2 repeater-title">
                                                        {{ trans('cruds.invoice.fields.unit_total') }}
                                                    </p>
                                                    <div class="mx-auto me-0">
                                                        <a class="btn px-0 me-1 py-0 new_save" id="0" data-edit="0">
                                                            <i class="bx bxs-check-circle fs-5 text-success cursor-pointer" title="save each particular" ></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <input type="text" style="text-align:right" name="" class="form-control unit_total total" id="add_total0" value="0" disabled>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-start justify-content-between px-2" style="padding-top:2.6rem;padding-bottom:1rem;">
                                            <a class="btn px-0 me-1 py-0 addProduct">
                                                <i class="bx bx-plus fs-4 text-primary cursor-pointer"></i>
                                            </a>

                                            <a class="btn px-0 me-1 py-0 remove" id="0" data-delete="1">
                                                <i class="bx bx-minus fs-4 text-danger cursor-pointer" ></i>
                                            </a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="row w-100 m-0 ps-3 pe-5">
                    <div class="col-md-2 offset-md-8 mt-3">
                        <label class="" for="total_qty">{{ trans('cruds.invoice.fields.total_qty') }}</label>
                                <input class="form-control {{ $errors->has('total_qty') ? 'is-invalid' : '' }} text-end" type="number"
                                name="total_qty" id="total_qty" value="{{ old('total_qty', $invoice->total_qty) }}" readonly> 
                                @if ($errors->has('total_qty'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('total_qty') }}
                                    </div>
                                @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.total_qty_helper') }}</span>
                    </div>
                    <div class="col-md-2 mt-3">
                        <label class="" for="total_qty">{{ trans('cruds.invoice.fields.total') }}</label>
                        <input class="form-control {{ $errors->has('total') ? 'is-invalid' : '' }} text-end" type="number"
                                name="total" id="total" value="{{ old('total', $invoice->total) }}" readonly> 
                                @if ($errors->has('total'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('total') }}
                                    </div>
                                @endif
                       <span class="help-block">{{ trans('cruds.invoice.fields.total_helper') }}</span>   
                    </div>
                </div>
                <div class="row w-100 m-0 ps-3 pe-5">
                    <div class="col-md-2 offset-md-10 mt-3">
                        <div class="form-group">
                            <label class="required" for="received_total_amount">{{ trans('cruds.invoice.fields.received_total_amount') }}</label>
                            <input required class="form-control text-end {{ $errors->has('received_total_amount') ? 'is-invalid' : '' }}" type="number"
                                name="received_total_amount" id="received_total_amount" value="{{ old('received_total_amount', $invoice->received_total_amount) }}" >
                            @if ($errors->has('received_total_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('received_total_amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.invoice.fields.received_total_amount_helper') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-3 d-flex">
                    <div class="form-group mt-2">
                        <button class="btn btn-success" type="submit" id="save">
                            {{ trans('global.save') }}
                        </button>
                        <a onclick=history.back() class="btn btn-secondary text-white">Cancel</a>
                    </div>                        
                </div>
            </form>
        </div>
    </div>
    
@endsection



@section('scripts')
    {{-- fileupload script --}}
    <script>
        $(function(){
            //file click
            $('.dropzone-wrapper').on('click', function(){
                $('#file-' + $(this).attr('id')).click();
            })

            //preview image
            $('.imagefile').on('change', function(){
                var wrapper = $(this).attr('data-id');
                var file = $(this)[0].files[0];
                if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // $('#' + wrapper).attr('style', 'background-image', 'url(' + e.target.result + ')');
                    $('#' + wrapper+'-preview').attr('style', 'background-image: url(' + e.target.result + '); background-repeat: no-repeat; background-position: center;');
                }
                reader.readAsDataURL(file);
                }
            })
        })
    </script>
    <script>
        var uploadedImagesMap = {}

        Dropzone.options.imagesDropzone = {
            url: '{{ route('admin.invoices.storeMedia') }}',
            maxFiles: 4,
            maxFilesize: 10, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 10,
            width: 4096,
            height: 4096
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
            uploadedImagesMap[file.name] = response.name
            },
            removedfile: function (file) {
            console.log(file)
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedImagesMap[file.name]
            }
            $('form').find('input[name="images[]"][value="' + name + '"]').remove()
            },
            init: function () {
                this.on("maxfilesexceeded", function(file){
                    this.removeFile(file);
                });
        @if(isset($invoice) && $invoice->images)
            var files = {!! json_encode($invoice->images) !!}
                for (var i in files) {
                var file = files[i]
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
                file.previewElement.classList.add('dz-complete')
                $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
                }
        @endif
            },
            error: function (file, response) {
                if ($.type(response) === 'string') {
                    var message = response //dropzone sends it's own error messages in string
                } else {
                    var message = response.errors.file
                }
                file.previewElement.classList.add('dz-error')
                _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                _results = []
                for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                    node = _ref[_i]
                    _results.push(node.textContent = message)
                }

                return _results
            }
        }
    </script>
    <script>
    var btnCount = $('.product-count').length;

    $(document).on('click','.addProduct', function() {
        $('#container').append(`<div class="d-flex rounded position-relative pe-0" id="row${btnCount}">
                                    <div class="row w-100 m-0 p-3">
                                        <div class="col-md-6 col-12 mb-md-0 ps-md-0">
                                            <p class="mb-2 repeater-title">Product</p>
                                            <select class="form-control select2 add_product_name {{ $errors->has('product_name') ? 'is-invalid' : '' }}" name="add_product_name${btnCount}" id="add_product_name${btnCount}" required>
                                            @foreach ($product_names as $id => $entry)
                                                    
                                                <option value="{{ $id }}" {{ old('product_name${btnCount}') == $id ? 'selected' : '' }}>
                                                {{ $entry }}
                                                </option>
                                            
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-12 mb-md-0">
                                            <p class="mb-2 repeater-title">Sales Price</p>
                                            <input type="text" style="text-align:right" name="" class="form-control unit_price" id="add_unit_price${btnCount}" value="0" disabled>
                                        </div>
                                        <div class="col-md-2 col-12 mb-md-0">
                                            <p class="mb-2 repeater-title">{{ trans('cruds.invoice.fields.qty') }}</p>
                                            <input type="number" style="text-align:right" name="add_qty${btnCount}" class="form-control add_qty" id="add_qty${btnCount}" value="0" min="1">
                                            <input type="hidden" id="add_max${btnCount}" value="0">
                                            </div>
                                        <div class="col-md-2 col-12 pe-0">
                                            <div class="d-flex justify-content-between">
                                                    <p class="mb-2 repeater-title">
                                                        {{ trans('cruds.invoice.fields.unit_total') }}
                                                    </p>
                                                    <div class="mx-auto me-0">
                                                        <a class="btn px-0 me-1 py-0 new_save" id="${btnCount}" data-edit="0">
                                                            <i class="bx bxs-check-circle fs-5 text-success cursor-pointer" title="save each particular" ></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            <input type="text" style="text-align:right" name="" class="form-control unit_total total" id="add_total${btnCount}" value="0" disabled>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column align-items-start justify-content-between px-2" style="padding-top:2.6rem;padding-bottom:1rem;">
                                            <a class="btn px-0 me-1 py-0 addProduct">
                                                <i class="bx bx-plus fs-4 text-primary cursor-pointer"></i>
                                            </a>

                                            <a class="btn px-0 me-1 py-0 remove" id="${btnCount}" data-delete="1">
                                                <i class="bx bx-minus fs-4 text-danger cursor-pointer" ></i>
                                            </a>
                                        </div>
                                </div>
         `);
        btnCount++;
    });

    $(document).on('click', '.edit', function() {
        var id = $(this).attr('id');
        if ($("#qty" + id).attr('disabled')) {
            $("#qty" + id).removeAttr('disabled');
        } else {
            $("#qty" + id).val($("#qty" + id).data('qty'));
            $("#qty" + id).attr('disabled', 'disabled');
        }

    });



    //new products
    $(document).on("change", ".add_product_name", function() {
        var product_name_id = $(this).attr('id');
        var number = parseInt(product_name_id.replace('add_product_name', ''));
        var id = $(this).find(":selected").val();
        $.ajax({
            type: 'GET',
            url: '/product/price',
            data: {
                id: id
            },
            success: function(data) {
                var price = data[0];
                $('#add_max' + number).val(data[1]);
                if (data[1] != 0) {
                    $('#add_qty' + number).val(1);
                    $('#qty' + number).data('qty', data[1]);
                    var qty = $('#add_qty' + number).val();
                    var subtotal = 0;
                    $('#add_unit_price' + number).val(price);
                    $('#add_total' + number).val(price * qty);
                    var linetotals = $('.total');
                    for (var i = 0; i < linetotals.length; i++) {
                        subtotal += parseInt($(linetotals[i]).val());
                    }
                    $('#sub_total').html(subtotal);
                } else {
                    alert("stock qty is 0! You can't select this product");
                    $(`.add_product_name${number}`).val($(`#product_name${number}`).data(
                        'product-id'));
                    $(`#add_qty${number}`).val(0);
                    $(`#add_unit_price${number}`).val(0);
                    $(`#add_total${number}`).val(0);
                }
                getTotalAndQty()
            },
            error: function(data) {
                console.log(data);
            }
        })
    })

    //new products
    $(document).on('input', '.add_qty', function() {

        var qtyid = $(this).attr('id');
        var number = parseInt(qtyid.replace('add_qty', ''));
        var max = $('#add_max' + number).val();
        var qty = $(this).val();
        var id = $('.add_product_name' + number).find(":selected").val();
        var subtotal = 0;
        if (parseInt($(this).val()) > parseInt(max)) {
            alert('Your product qty is more than stock qty! Stocks = ' + max);
            var cost = parseInt($('#add_unit_price' + number).val());
            $(this).val(max);
            $('#add_total' + number).val(max * cost);
        } else {
            if (parseInt($(this).val()) <= parseInt(max) || $(this).val() < $(this).data('qty')) {
                $.ajax({
                    type: 'GET',
                    url: `/product/price/`,
                    data: {
                        id: id
                    },
                    success: function(data) {
                        var price = qty * data[0];
                        $('#add_max' + number).val(data[1]);
                        $('#add_total' + number).val(price);
                        var linetotals = $('.total');
                        for (var i = 0; i < linetotals.length; i++) {
                            subtotal += parseInt($(linetotals[i]).val());
                        }
                        $('#sub_total').html(subtotal);
                    },
                    error: function(data) {
                        console.log(data);
                    }
                })
            }
        }
    });

    //save new products
    $(document).on('click', '.new_save', function() {
        var id = $(this).attr('id');
        var product_id = $('#add_product_name' + id).val();
        var invoice_id = $('#invoice_id').val();
        var qty = $('#add_qty' + id).val();
        var line_total = $('#add_total' + id).val();
        var subTotal = $('#sub_total').text();
        $.ajax({
            type: 'PUT',
            url: `/admin/invoices/${invoice_id}`,
            data: {
                'edit': '2',
                'product_id': product_id,
                'invoice_id': invoice_id,
                'qty': qty,
                'line_total': line_total,
                'sub_total': subTotal,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                alert(data);
                $(".add_product_name" + id).attr('disabled', 'disabled');
                $("#add_qty" + id).attr('disabled', 'disabled');
                location.reload(true);
            }
        })
    })

    $(document).on('click', '.remove', function() {
        var id = $(this).attr('id');
        var sub_total = parseInt($('#sub_total').text());
        sub_total -= parseInt($('#add_total' + id).val());
        $('#sub_total').html(sub_total);
        $("#row" + id).remove();
        --btnCount;
    })

    $(document).on('click', '.save', function() {
        var id = $(this).attr('id');
        var old_product_id = $('#product_name' + $(this).attr('id')).data('product-id');
        var new_product_id = $('#product_name' + $(this).attr('id')).val();
        var invoice_id = $('#invoice_id').val();
        var qty = $('#qty' + $(this).attr('id')).val();
        var line_total = $('#total' + $(this).attr('id')).val();
        var total_qty = 0;
        var qty_inputs = $('.qty');
        for (var i = 0; i < qty_inputs.length; i++) {
            total_qty += +$(qty_inputs[i]).val();
        }
        var subTotal = $('#sub_total').text();
        $.ajax({
            type: 'PUT',
            url: `/admin/invoices/${invoice_id}`,
            data: {
                'edit': '1',
                'old_id': old_product_id,
                'new_id': new_product_id,
                'invoice_id': invoice_id,
                'qty': qty,
                'line_total': line_total,
                'total_qty': total_qty,
                'sub_total': subTotal,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                alert(data);
                $("#product_name" + id).attr('disabled', 'disabled');
                $("#qty" + id).attr('disabled', 'disabled');
            }
        })
    })

    $('.deleteProduct').on('click', function() {
        if (btnCount > 1) {
        var id = $(this).attr('id');
        var invoice_id = $('#invoice_id').val();
        $.ajax({
            type: 'GET',
            url: `/admin/invoices/product/delete`,
            data: {
                'product_id': id,
                'invoice_id': invoice_id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#product' + id).remove();
                --btnCount;
                alert(data);
            }
        })
        } else 
        {
            alert("You can't delete all Products")
        }
    })


    var qtyTag = document.querySelector('.qty');
    var nameTag = document.querySelector('.product_name');
    var max = 0;
    //test multiple forms
    $(document).on("change", ".product_name", function() {
        var product_name = $(this).attr('id');
        var number = parseInt(product_name.replace('product_name', ''));
        var length = $('.product_name').length;
        for (var i = 0; i < length; i++) {
            if ($(`#product_name${i}`).find(":selected").val() == $(this).find(":selected").val() && $(
                    `#product_name${i}`).attr('id') != $(this).attr('id')) {
                alert('product has been already selected');
                $(`#${product_name}`).prop('selectedIndex', 0);
                $(`#qty${number}`).val('');
                $(`#unit_total${number}`).val('');
                return
            };
        }
        var id = $(this).find(":selected").val();
        $.ajax({
            type: 'GET',
            url: '/product/price',
            data: {
                id: id
            },
            success: function(data) {
                var price = data[0];
                var subtotal = 0;
                $('#max' + number).val(data[1]);
                if (data[1] != 0) {
                    $('#qty' + number).val(1);
                    $('#cost' + number).val(price);
                    $('#unit_total' + number).val(price);
                    var unit_total = $(".unit_total");

                    for (var i = 0; i < unit_total.length; i++) {
                        if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                            subtotal += parseInt($(unit_total[i]).val());
                        }
                    }
                    $('#subtotal').html(subtotal + " Ks");

                } else {
                    alert("stock qty is 0! You can't select this product");
                    $(`#${product_name}`).prop('selectedIndex', 0);
                    $(`#qty${number}`).val('');
                    $(`#unit_total${number}`).val('');
                }
                
            },
            error: function(data) {
                console.log(data);
            }
        })
    });
    $(document).on('input', '.qty', function() {
        var qtyid = $(this).attr('id');
        var number = parseInt(qtyid.replace('qty', ''));
        var qty = $(this).val();
        var max = $('#max' + number).val();
        if (parseInt($(this).val()) > parseInt(max)) {
            alert('Your product qty is more than stock qty! Stocks = ' + max);
            $(this).val(max);
            qty = max;
        }
        var id = $('#product_name' + number).find(":selected").val();
        $.ajax({
            type: 'GET',
            url: '/product/price',
            data: {
                id: id
            },
            success: function(data) {

                var price = qty * data[0];
                $('#total' + number).val(price);
                var subtotal = 0;
                var unit_total = $(".unit_total");

                for (var i = 0; i < unit_total.length; i++) {
                    if (!Number.isNaN(parseInt($(unit_total[i]).val()))) {
                        subtotal += parseInt($(unit_total[i]).val());
                    }
                }
                getTotalAndQty()
            },
            error: function(data) {
                console.log(data);
            }
        })
        
    })


    $('#start_meter').on('input',function(){
        getDropCableLength()
    })
    $('#end_meter').on('input',function(){
        getDropCableLength()
    })

    function getDropCableLength(){
        let start_meter = $('#start_meter').val() || 0;
        let end_meter = $('#end_meter').val() || 0;
        $('#drop_cable_length').val(parseInt(start_meter)-parseInt(end_meter));
    }

    function getTotalAndQty(){
        let unit_total = $('.unit_total');
        let qty = $('.qty');
        let total = 0, total_qty = 0;
        for(let i=0;i<unit_total.length;i++){
            total += parseInt($(unit_total[i]).val() || 0);
            total_qty += parseInt($(qty[i]).val() || 0);
        } 
        $('#total').val(total);
        $('#total_qty').val(total_qty);
    }

    $(() => {
        var flatpickrAssignDate = document.querySelector('#assign_date');
        var flatpickrIssueDate = document.querySelector('#issue_date');
        var flatpickrSuspendDate = document.querySelector('#suspend_date');
        var flatpickrFinishedDate = document.querySelector('#finished_date');
        var flatpickrReceivedDate = document.querySelector('#received_date');
        if (flatpickrAssignDate) {
            flatpickrAssignDate.flatpickr({
                monthSelectorType: 'static'
            });
        }

        if (flatpickrIssueDate) {
            flatpickrIssueDate.flatpickr({
                monthSelectorType: 'static'
            });
        }

        if (flatpickrSuspendDate) {
            flatpickrSuspendDate.flatpickr({
                monthSelectorType: 'static'
            });
        }

        if (flatpickrFinishedDate) {
            flatpickrFinishedDate.flatpickr({
                monthSelectorType: 'static'
            });
        }

        if (flatpickrReceivedDate) {
            flatpickrReceivedDate.flatpickr({
                monthSelectorType: 'static'
            });
        }
    })

    $('#save').on('click', function(e) {
        document.getElementById("myForm").submit();
    })


    </script>
@endsection
