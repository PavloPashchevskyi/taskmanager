@component('mail::message')
# You have some tasks to execute. Bellow are the details

@component('mail::table')
    |Task ID|Task title|Due date|Attachment path|Complete|
    |:------|:---------|:-------|:--------------|:-------|
    @foreach($reminders as $reminder)
        |{{$reminder['id']}}|{{$reminder['title']}}|{{$reminder['due_date']}}|{{empty($reminder['attachment_path']) ? 'No data' : $reminder['attachment_path']}}|{{empty($reminder['complete']) ? 'No' : 'Yes'}}|
    @endforeach
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
