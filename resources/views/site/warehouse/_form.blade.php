@extends('layouts.master')

@section('title')
    <h3>นำเข้าข้อมูล</h3>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="row" style="max-height: 215px;">
                        <div class="col">
                            <form method="post" action="./load" class="dropzone" id="drop-file">
                                @csrf
                            </form>
                        </div>
                        <div class="col">
                            <div class="card bg-light border shadow-none" style="height: 215px">
                                <div class="card-body text-monospace p-2 overflow-auto" id="console_log">

                                </div>
                                <div id="card_footer" class="card-footer" style="display:none">
                                    <form method="post" action="{{ route('site.warehouse.import', $campaign->id) }}">
                                        @csrf
                                        <textarea id="data" name="data" type="text"></textarea>
                                        <button id="btn_submit" type="submit"></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
