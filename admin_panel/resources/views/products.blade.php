@extends('Admin::layout')

@section('content')
<v-container fluid>
  <v-row justify="center">
    <v-col cols="10">
      <app-product-table></app-product-table>
    </v-col>
  </v-row>
</v-container>
@endsection