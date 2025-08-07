<x-mail::message>
# New Assignment Posted

Dear Parent/Guardian,

A new assignment titled **"{{ $assignmentTitle }}"** has been posted and is now available for your child. Kindly review the details and ensure your child completes it before the due date.

- **Title:** {{ $assignmentTitle }}
- **Description:** {{ $assignmentDescription }}
- **Due Date:** {{ \Carbon\Carbon::parse($dueDate)->format('F j, Y') }}

<x-mail::button :url="route('assignments.view', $assignment->id)">
View Assignment
</x-mail::button>

Thank you for your continued support in your child's academic journey.

Regards,<br>
{{ config('app.name') }}
</x-mail::message>
