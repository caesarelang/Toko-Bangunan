@extends('Owner.Layouts.app')

@section('content')
<h2 class="mb-4">Product Management</h2>

<ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="all-products-tab" data-bs-toggle="tab" data-bs-target="#all-products" type="button" role="tab">
      All Products
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="top-products-tab" data-bs-toggle="tab" data-bs-target="#top-products" type="button" role="tab">
      Top Selling Products
    </button>
  </li>
</ul>

<div class="tab-content" id="productTabsContent">
  <!-- All Products -->
  <div class="tab-pane fade show active" id="all-products" role="tabpanel">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
        </tr>
      </thead>
      <tbody>
        @foreach($products as $product)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $product->name }}</td>
          <td>{{ $product->category->name ?? '-' }}</td>
          <td>Rp {{ number_format($product->price,0,',','.') }}</td>
          <td>{{ $product->stock }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <!-- Top Selling Products -->
  <div class="tab-pane fade" id="top-products" role="tabpanel">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>Sold Quantity</th>
        </tr>
      </thead>
      <tbody>
        @foreach($topProducts as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->product->name }}</td>
          <td>{{ $item->total_sold }}</td>
        </tr>
        @endforeach
        @if($topProducts->isEmpty())
        <tr>
          <td colspan="3" class="text-center">No top selling products this month</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endsection
