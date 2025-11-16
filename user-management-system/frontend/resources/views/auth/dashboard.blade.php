@extends('layouts.app')
@section('content')
<h3>Dashboard</h3>
<div class="card p-3">
    <p><strong>Name:</strong> {{ data_get($user,'name','-') }}</p>
    <p><strong>Email:</strong> {{ data_get($user,'email','-') }}</p>
    <p><strong>Role:</strong> {{ data_get($user,'role','-') }}</p>
</div>
@endsection
