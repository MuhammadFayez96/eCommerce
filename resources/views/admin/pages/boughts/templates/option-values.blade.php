@foreach($values as $value)

    <option value="{{$value->id}}">{{$value->trans->value}}</option>

@endforeach
