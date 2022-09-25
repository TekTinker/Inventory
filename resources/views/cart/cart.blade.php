@extends('layouts.app')

@section('content')

    <div class="content">
        <div class="container">
            <div class="row py-4">
                <div class="col-12">
                    <p class="h2 text-center">Cart</p>
                </div>
            </div>
            <div class="row py-4">
                <div class="col-12">
                    @if(count($carts))
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Color</th>
                                <th scope="col">Cost/Unit</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col" colspan="2" class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td>{{ $cart->product_id }}</td>
                                    <td>{{ $cart->name }}</td>
                                    <td>{{ $cart->type }}</td>
                                    <td>{{ $cart->color }}</td>
                                    <td>{{ $cart->total_cost }}</td>
                                    <td>{{ $cart->quantity }}</td>
                                    <td>{{ $cart->total_cost * $cart->quantity }}</td>
                                    <td>
                                        <button style="display: block;"
                                                class="btn btn-info btn-block"
                                                data-toggle="modal"
                                                data-target="#editQuantity"
                                                data-id="{{ $cart->product_id }}"
                                                data-name="{{ $cart->name }}"
                                                data-url="{{ route('carts.update', ['id' => $cart->id]) }}"
                                                data-quantity="{{ $cart->quantity }}">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <form action="{{ route('carts.destroy', ['id' => $cart->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                </div>

                @else
                    <div class="row justify-content-center">
                        Cart Empty
                    </div>
                @endif
            </div>
            @if(count($carts))
                <div class="row py-2">
                    <div class="col-6">
                        <p class="h4">Order Total : &#8377; {{ $grand_total }} /-</p>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-success" data-toggle="modal" data-target="#placeOrder">Place Order</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!--Modals-->
    <div class="modal fade" id="editQuantity" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ModalLabel">Modal Title</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-4">Quantity</div>
                            <div class="col-4">
                                <input type="text" name="quantity"/>
                            </div>
                            <input type="hidden" name="product_id"/>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="placeOrder" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">Place Order</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <td>Delivery Data</td>
                                <td><input type="date" name="delivery_date" required value="25/02/2019"/></td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td><input type="text" name="department" required value="Dept"/></td>
                            </tr>
                            <tr>
                                <td>Remark</td>
                                <td><input type="text" name="remark" required value="Remark"/></td>
                            </tr>
                            <tr>
                                <td>Order Total</td>
                                <td>&#8377; {{ $grand_total }} /-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $('#editQuantity').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var quantity = button.data('quantity');
                var name = button.data('name');
                var url = button.data('url');
                var modal = $(this);
                modal.find('.modal-title').text(name);
                modal.find(".modal-body input[name|='quantity']").val(quantity);
                modal.find(".modal-body input[name|='product_id']").val(id);
                modal.find(".modal-content form").attr("action", url);
            });
        });
    </script>


@endsection