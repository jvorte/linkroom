<h2>Νέο μήνυμα επικοινωνίας</h2>
<p><strong>Όνομα:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Μήνυμα:</strong><br>{{ nl2br(e($data['message'])) }}</p>
