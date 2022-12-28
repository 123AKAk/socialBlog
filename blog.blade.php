@extends('user.layouts.app')

@section('content')

    <!-- Hero Start -->
    <section class="bg-home sub_bg" style="background-image:url('{{ asset('user/images/English-Efik dictionary.jpg') }}')" id="home">
        <div class="bg-overlay"></div>
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="title-heading text-center mt-5 pt-4">
                                <h1 class="heading text-white mb-3">Blog Page</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero End -->

    <div class="container-fluid pt-4">
        <div class="jumbotron text-center">
            <div id="logo"></div>
            <h1 class="display-4 mb-3" style="font-weight: 500;">Tete Efik Dictionary Blog Page</h1>
            <a class="btn btn btn-lg" style="color: green;" href="https://medium.com/@philipakoda" target="_blank" role="button">View all posts</a>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="" id="medium">
                    <div class="row" id="jsonContent">
                    </div>
                    <center>
                        <ul class="pagination" id="pagin" style="text-align: center;">
                        </ul>
                    </center>
            
                    <!-- modal here -->
                    <div class="modal" id="exampleModal">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                            
                                <!-- Modal Header -->
                                <div class="modal-header">
                                <h3 class="modal-title">Tete Efik Dictionary Blog</h3>
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                </div>
                                
                                <!-- Modal body -->
                                <div class="modal-body">
                                <h3 style="color: green;" id="bodytitle"></h3>
                                <br>
                                <p id="bodytext">
                                </p>
                                </div>
                                
                                <!-- Modal footer -->
                                <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card">
                    <h5>Ads here</h5>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')

@endpush