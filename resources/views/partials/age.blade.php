@if(\Illuminate\Support\Carbon::parse($birthDate)->diffInYears(\Illuminate\Support\Carbon::now()) < 2)
    {{\Illuminate\Support\Carbon::parse($birthDate)->diffInMonths(\Illuminate\Support\Carbon::now())}} Months Old
@else
    {{\Illuminate\Support\Carbon::parse($birthDate)->diffInYears(\Illuminate\Support\Carbon::now())}} Years Old
@endif
