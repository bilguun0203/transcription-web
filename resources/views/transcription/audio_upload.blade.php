@extends('transcription.layout.main')

@section('title', 'Prototype - Index')

@section('content')
    <div class="container" style="margin-top: 20px;">
        <div class="text-center">
            <h2><i class="far fa-music"></i> <i class="far fa-arrow-right"></i> <i class="far fa-font"></i></h2>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-sm-8 col-xs-12">
                <div class="card">
                    <form>
                        {{ csrf_field() }}
                        <div class="card-body">
                            <input type="file" id="audios" name="audios" multiple>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info btn-block btn-raised"><i class="far fa-upload"></i> Хуулах</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection