@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row py-2">
                <div class="col-10">
                    <p class="h3">Current Required Materials for {{ $product->name }}</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Color</th>
                            <th scope="col">Price/Unit</th>
                            <th scope="col">Required Amount</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($materials as $material)
                            <tr>
                                <th scope="row">{{ $material->id }}</th>
                                <td>{{ $material->name }}</td>
                                <td>{{ $material->color }}</td>
                                <td>Rs {{ $material->price }} / {{ $material->unit }}</td>
                                <td>{{ $material->pivot->required }} {{ $material->unit }}</td>
                                <td>
                                    <form method="POST" class="form-inline"
                                          action="{{ route('products.remove_material', ['id' => $product->id]) }}">
                                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-end">
                <p class="h5">Total Cost Rs {{ $cost }}</p>
            </div>


            <hr class="h-100 py-5"/>



            <div class="row py-5">
                <div class="col-12">
                    <p class="h3">Add Material</p>
                </div>
            </div>

            <div class="row py-4">
                <div class="form-row col-7">
                    <input class="form-control" id="material_search" type="text" placeholder="Search.."/>
                </div>

                <div class="form-row col-5">
                    <select class="form-control for" id="material_color">
                        <option selected value="">Color</option>
                        @foreach(config('constants.colors') as $c)
                            <option value={{ $c }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col" onclick="sortTable(0)" style="cursor: pointer">#</th>
                            <th scope="col" onclick="sortTable(1)" style="cursor: pointer">Name</th>
                            <th scope="col" onclick="sortTable(2)" style="cursor: pointer">Color</th>
                            <th scope="col" onclick="sortTable(3)" style="cursor: pointer">Price/Unit</th>
                            <th scope="col">Required Amount</th>
                        </tr>
                        </thead>
                        <tbody id="material_list">
                        @foreach ($materials_all as $material)
                            <tr>
                                <td class="font-weight-bold">{{ $material->id }}</td>
                                <td class="search_field">{{ $material->name }}</td>
                                <td class="filter_color">{{ $material->color }}</td>
                                <td>Rs {{ $material->price }} / {{ $material->unit }}</td>
                                <td>
                                    <form method="POST" class="form-inline"
                                          action="{{ route('products.add_material', ['id' => $product->id]) }}">
                                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                                        @csrf
                                        <input type="text" name="required" placeholder="Quantity" />
                                        <button type="submit" class="btn btn-success">Add</button>

                                    </form>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>

                    </table>

                    <script>
                        //Filter and search
                        $(document).ready(function () {
                            $("#material_search").on("keyup", function () {
                                var value = $(this).val().toLowerCase();
                                $("#material_list tr").filter(function () {
                                    $(this).toggle($("td.search_field", this).text().toLowerCase().indexOf(value) > -1)
                                });
                                filter_color();

                                if (value == "") {
                                    $("#material_list tr").show()
                                    filter_color();
                                }
                            });

                            $("#material_color").on("change", function () {
                                var value = $(this).val().toLowerCase();

                                if (value != "") {
                                    $("#material_list tr").filter(function () {
                                        $(this).toggle($("td.filter_color", this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                    material_search();
                                } else {
                                    $("#material_list tr").show()
                                    material_search();
                                }
                            });

                            function filter_color() {
                                var value = $("#material_color").val().toLowerCase();
                                $("#material_list tr:visible").filter(function () {
                                    $(this).toggle($("td.filter_color", this).text().toLowerCase().indexOf(value) > -1)
                                });
                            }

                            function material_search() {
                                var value = $("#material_search").val().toLowerCase();
                                $("#material_list tr:visible").filter(function () {
                                    $(this).toggle($("td.search_field", this).text().toLowerCase().indexOf(value) > -1)
                                });
                            }
                        });

                        // Sorting
                        function sortTable(n) {
                            var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                            table = document.getElementById("material_list");
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
