
<table class="table table-bordered table-condensed">
    <tr>
        <th id="villa_no" @click="onClickSort" :class="{ 'info':searchField=='villa_no' }">
            Villa No 
            <i class="fa fa-fw " :class="headerSortingChange('villa_no')"></i></span>
        </th>
        <th id="location" @click="onClickSort" :class="{ 'info':searchField=='location' }">
            Location 
            <i class="fa fa-fw" :class="headerSortingChange('location')"></i>
        </th>
        <th id="electricity_no" @click="onClickSort" :class="{ 'info':searchField=='electricity_no' }">
            Electricity No 
            <i class="fa fa-fw " :class="headerSortingChange('electricity_no')"></i>
        </th>
        <th id="water_no" @click="onClickSort" :class="{ 'info':searchField=='water_no' }">
            Water No 
            <i class="fa fa-fw" :class="headerSortingChange('water_no')"></i>
        </th>
        <th id="qtel_no" @click="onClickSort" :class="{ 'info':searchField=='qtel_no' }">
            QTel No 
            <i class="fa fa-fw" :class="headerSortingChange('qtel_no')"></i>
        </th>
        <th id="villa_class" @click="onClickSort" :class="{ 'info':searchField=='villa_class' }">
            Villa Class 
            <i class="fa fa-fw" :class="headerSortingChange('villa_class')"></i>
        </th>
        <th id="rate_per_month" @click="onClickSort" :class="{ 'info':searchField=='rate_per_month' }">
            Rate/Month 
            <i class="fa fa-fw" :class="headerSortingChange('rate_per_month')"></i>
        </th>
        <th id="status" @click="onClickSort" :class="{ 'info':searchField=='status' }">
            Status 
            <i class="fa fa-fw" :class="headerSortingChange('status')"></i></th>
        <th></th>
    </tr>

    <tr v-for="item in lists" >
        <td>@{{item.villa_no}}</td>
        <td>@{{item.full_location}}</td>
        <td>@{{item.electricity_no}}</td>
        <td>@{{item.water_no}}</td>
        <td>@{{item.qtel_no}}</td>
        <td>@{{item.full_villa_class}}</td>
        <td>@{{item.rate_per_month}}</td>
        <td>@{{item.full_status}}</td>
        <td class="text-center">
            <button class="btn btn-default btn-xs" @click="onEdit('{!!url('/villa/register/')!!}',item.id)"><i class="fa fa-pencil"></i></button>
            <button class="btn btn-danger btn-xs" @click="onRemove('{!!url('/villa/register/')!!}',item.id)"><i class="fa fa-close"></i></button>
        </td>
    </tr>
</table>
