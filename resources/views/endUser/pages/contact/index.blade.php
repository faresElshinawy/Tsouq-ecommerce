@extends('endUser.layouts.master')


@section('title', 'tsouq Contact')


@section('page title', Setting::get('contact-header'))

@section('page', Setting::get('contact-title'))

@section('content')
    @include('endUser.layouts.header')

    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">{{ Setting::get('contact-sub-header') }}</span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div class="control-group">
                        <input type="text" class="form-control mb-2" value="{{ old('name') }}" id="name"
                            placeholder="Your Name" name='name' />
                    </div>
                    <div class="control-group">
                        <input type="email" class="form-control mb-2" name='email' value="{{ old('email') }}" id="email"
                            placeholder="Your Email" />
                    </div>
                    <div class="control-group">
                        <input type="text" class="form-control mb-2" name='subject' value="{{ old('subject') }}"
                            id="subject" placeholder="Subject" />
                    </div>
                    <div class="control-group">
                        <textarea class="form-control mb-2" name='message' id="message" rows="6" id="message" placeholder="Message"></textarea>
                    </div>
                    <div>
                        <button class="btn btn-primary py-2 px-4" type="submit" id="new-feedback-submit-btn">Send
                            Message</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3">Get In Touch</h5>
                <p>{{ Setting::get('contact-description') }}</p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Store</h5>
                    <p class="mb-2"><i
                            class="fa fa-map-marker-alt text-primary mr-3"></i>{{ Setting::get('store-address') }}</p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>{{ Setting::get('store-email') }}</p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i>{{ Setting::get('store-phone') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

@endsection

@section('js')
    <script>
        $('#new-feedback-submit-btn').click(function() {
            var name = $('input[name="name"][type="text"]').val();
            var email = $('input[name="email"][type="email"]').val();
            var subject = $('input[name="subject"][type="text"]').val();
            var message = $('#message').val();
            $.ajax({
                url: '{{ route('contact.store') }}',
                type: 'post',
                datatype: 'json',
                cache: false,
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name': name,
                    'email': email,
                    'subject': subject,
                    'message': message
                },
                success: function(data) {
                    if (data.code == 400) {
                        var errors = [];
                        var html = '';
                        for (var key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                errors.push(data.errors[key]);
                            }
                        }
                        html = errors.join('<br>');
                        Swal.fire({
                            icon: 'error',
                            title: 'validation error',
                            html: html,
                            showConfirmButton: false
                        })
                    } else if (data.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false
                        })
                        $('input[name="name"][type="text"]').val('');
                        $('input[name="email"][type="email"]').val('');
                        $('input[name="subject"][type="text"]').val('');
                        $('#message').val('');
                    }
                }
            })
        });
    </script>
@endsection
