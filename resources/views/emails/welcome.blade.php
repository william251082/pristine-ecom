Hello {{$user->name}}
Thanks for creating an account. Please verify your email using this link:
{{route('verify', $user->verification_token)}}
