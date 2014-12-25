<!-- start: BREADCRUMB -->
<div class="row">
    <div class="col-md-12">
        <ol class="breadcrumb">
            @foreach($breadcrumb as $crumb)
                @if($crumb['url'] != '')
                    <li>
                        <a href="{{$crumb['url']}}">
                            {{$crumb['label']}}
                        </a>
                    </li>
                @else
                    <li class="active">
                        {{$crumb['label']}}
                    </li>
                @endif
            @endforeach
        </ol>
    </div>
</div>
<!-- end: BREADCRUMB -->