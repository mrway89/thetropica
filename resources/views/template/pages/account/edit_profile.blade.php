@extends('template/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="content-area">
	<div class="container container-product">
		<div class="row">
            <div class="col-md-9 col-sm-12 col-12 offset-md-3 offset-0 pt-3">
				<h3 class="bold-300 mb-4 pt-5">My Account</h3>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 col-6">
				@include('template/pages/account/includes/sidemenu')
			</div>
			<div class="col-lg-9 col-md-9 col-sm-12 col-12">
               <div class="row">
                   <div class="col-md-6">
                        <p class="bold-700 mb-4">Edit Account Details </p>
                        <form>
                            <div class="form-group">
                                <label class="label-14 font-weight-bold">Name</label>
                                <input type="text" class="form-control label-14 rounded-0" name="username" required/>
                            </div>
                            <div class="form-group">
                                <label class="label-14 font-weight-bold">Email</label>
                                <input type="email"  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control label-14 rounded-0" name="email" required/>
                            </div>
                            <div class="form-group">
                                <label class="label-14 font-weight-bold">Phone</label>
                                <input type="text" minlength="5" maxlength="12" onkeypress="return isNumberKey(event)" class="form-control label-14 rounded-0" name="phone" required/>
                            </div>
                            <div class="form-group">
                                <a href="{{url('frontend/account/profile')}}"><button type="button" class="btn btn-oval btn-cancel-pop mr-3">CANCEL</button></a>
                                <button type="submit" class="btn btn-oval btn-pink btn-addcart-popup">APPLY CHANGES</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('template/includes/footer')
@endsection

@section('custom_js')
<script>
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
</script>

@endsection
