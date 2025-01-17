<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>OpenAI Integration</title>
    </head>
    <body>
        {{-- {{ env('OPENAI_API_KEY') }} --}}
        <form id="openai-form">
            <label for="prompt">Enter your prompt:</label>
            <input type="text" id="prompt" name="prompt" required>
            <button type="submit">Submit</button>
        </form>

        <form id="upload-form" enctype="multipart/form-data">
            <label for="file">Upload a file:</label>
            <input type="file" id="file" name="file" required>
            <button type="submit">Upload</button>
        </form>

        <form id="csv-form" enctype="multipart/form-data">
            <label for="csv-file">Upload a CSV file:</label>
            <input type="file" id="csv-file" name="file" required>
            <button type="submit">Upload and Process</button>
        </form>

        <div id="response"></div>

        <script>
            document.getElementById('openai-form').addEventListener('submit', async function(event) {
                event.preventDefault();

                const prompt = document.getElementById('prompt').value;
                const responseDiv = document.getElementById('response');

                const response = await fetch('/openai-response', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ prompt: prompt })
                });

                console.log(response);

                const data = await response.json();
                responseDiv.innerText = data.response;
            });

            document.getElementById('upload-form').addEventListener('submit', async function(event) {
                event.preventDefault();

                const file = document.getElementById('file').files[0];
                const formData = new FormData();
                formData.append('file', file);

                const response = await fetch('/upload-file', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                console.log(response);

                const data = await response.json();
                console.log('File uploaded with ID:', data.file_id);
            });

            document.getElementById('csv-form').addEventListener('submit', async function(event) {
                event.preventDefault();

                const file = document.getElementById('csv-file').files[0];
                const formData = new FormData();
                formData.append('file', file);

                const response = await fetch('/process-csv', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const data = await response.json();
                document.getElementById('response').innerText = data.response;
            });
        </script>
    </body>
</html>
