<?php $dash.='-- '; ?>
@foreach($subcategories as $subcategory)
    <tr>
        <td><input type="checkbox" id="cbox1" name="categories_id" value="{{$subcategory->id}}" class="check" required>&nbsp;{{$dash}}{{$subcategory->descripcion}}</td>
        <td>{{$subcategory->parent->descripcion}}</td>
    </tr>
    @if(count($subcategory->subcategory))
        @include('sub-category-list',['subcategories' => $subcategory->subcategory])
    @endif
@endforeach
