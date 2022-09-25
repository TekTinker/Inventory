@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row py-4">
                <div class="col-10">
                    <p class="h3">List of Products</p>
                </div>
                <div class="col-2">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">Add New</a>
                </div>
            </div>
            <div class="row py-4">
                <div class="form-row col-6">
                    <input class="form-control" id="product_search" type="text" placeholder="Search.."/>
                </div>

                <div class="form-row col-3">
                    <select class="form-control" id="product_type">
                        <option selected value="">Type</option>
                        @foreach(config('constants.types') as $t)
                            <option value={{ $t }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row col-3">
                    <select class="form-control for" id="product_color">
                        <option selected value="">Color</option>
                        @foreach(config('constants.colors') as $c)
                            <option value={{ $c }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" onclick="sortTable(0)" style="cursor: pointer">#</th>
                            <th scope="col" onclick="sortTable(1)" style="cursor: pointer">Name</th>
                            <th scope="col" onclick="sortTable(2)" style="cursor: pointer">Type</th>
                            <th scope="col" onclick="sortTable(3)" style="cursor: pointer">Color</th>
                            <th scope="col" onclick="sortTable(4)" style="cursor: pointer">Description</th>
                            <th scope="col" colspan="2" class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody id="product_list">
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td class="search_field"><a
                                            href="{{ route('products.show', ['id' => $product->id]) }}">{{ $product->name }}</a>
                                </td>
                                <td class="filter_type">{{ $product->type }}</td>
                                <td class="filter_color">{{ $product->color }}</td>
                                <td class="search_field">{{ $product->description }}</td>
                                <td>
                                    <Form class="form-inline" action="{{ route('carts.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                        <button type="submit" style="display: block;" class="btn btn-primary">
                                            Add to Cart
                                        </button>
                                    </Form>
                                </td>
                                <td>
                                    <a style="display: block;" class="btn btn-info"
                                       href="{{ route('products.edit', ['id' => $product->id]) }}">
                                        Edit </a>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    <script>
                        //Filter and search
                        $(document).ready(function () {
                            $("#product_search").on("keyup", function () {
                                var value = $(this).val().toLowerCase();
                                $("#product_list tr").filter(function () {
                                    $(this).toggle($("td.search_field", this).text().toLowerCase().indexOf(value) > -1)
                                });

                                if (value == "") {
                                    filter_type();
                                    filter_color();
                                }
                            });

                            $("#product_type").on("change", function () {
                                var value = $(this).val().toLowerCase();

                                if (value != "") {
                                    filter_color();
                                    $("#product_list tr:visible").filter(function () {
                                        $(this).toggle($("td.filter_type", this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                } else {
                                    filter_color();
                                }
                            });

                            $("#product_color").on("change", function () {
                                var value = $(this).val().toLowerCase();

                                if (value != "") {
                                    filter_type();
                                    $("#product_list tr:visible").filter(function () {
                                        $(this).toggle($("td.filter_color", this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                } else {
                                    filter_type();
                                }
                            });

                            function filter_color() {
                                var value = $("#product_color").val().toLowerCase();
                                if (value != "") {
                                    $("#product_list tr").filter(function () {
                                        $(this).toggle($("td.filter_color", this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                }
                                else {
                                    $("#product_list tr").show()
                                }
                            }

                            function filter_type() {
                                var value = $("#product_type").val().toLowerCase();
                                if (value != "") {
                                    $("#product_list tr").filter(function () {
                                        $(this).toggle($("td.filter_type", this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                }
                                else {
                                    $("#product_list tr").show();
                                }
                            }
                        });

                        // Sorting
                        function sortTable(n) {
                            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                            table = document.getElementById("product_list");
                            switching = true;
                            //Set the sorting direction to ascending:
                            dir = "asc";
                            /*Make a loop that will continue until
                            no switching has been done:*/
                            while (switching) {
                                //start by saying: no switching is done:
                                switching = false;
                                rows = table.getElementsByTagName("TR");
                                /*Loop through all table rows (except the
                                first, which contains table headers):*/
                                for (i = 0; i < (rows.length - 1); i++) {
                                    //start by saying there should be no switching:
                                    shouldSwitch = false;
                                    /*Get the two elements you want to compare,
                                    one from current row and one from the next:*/
                                    x = rows[i].getElementsByTagName("TD")[n];
                                    y = rows[i + 1].getElementsByTagName("TD")[n];
                                    /*check if the two rows should switch place,
                                    based on the direction, asc or desc:*/
                                    if (dir == "asc") {
                                        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                            //if so, mark as a switch and break the loop:
                                            shouldSwitch = true;
                                            break;
                                        }
                                    } else if (dir == "desc") {
                                        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                            //if so, mark as a switch and break the loop:
                                            shouldSwitch = true;
                                            break;
                                        }
                                    }
                                }
                                if (shouldSwitch) {
                                    /*If a switch has been marked, make the switch
                                    and mark that a switch has been done:*/
                                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                                    switching = true;
                                    //Each time a switch is done, increase this count by 1:
                                    switchcount++;
                                } else {
                                    /*If no switching has been done AND the direction is "asc",
                                    set the direction to "desc" and run the while loop again.*/
                                    if (switchcount == 0 && dir == "asc") {
                                        dir = "desc";
                                        switching = true;
                                    }
                                }
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>

@endsection
