<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>تست فرم و آپلود چند عکس</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Tahoma, sans-serif;
            padding: 2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.35rem;
        }

        .form-group input, .form-group textarea {
            width: 100%;
            padding: 0.6rem 0.75rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .form-group textarea {
            min-height: 100px;
            resize: vertical;
        }

        .preview-zone {
            min-height: 100px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 0.5rem;
            background: #f9f9f9;
        }

        .preview-zone.empty .preview-list {
            display: none;
        }

        .preview-zone.empty .preview-placeholder {
            display: block;
        }

        .preview-zone .preview-placeholder {
            display: none;
            color: #999;
            text-align: center;
            padding: 1rem;
        }

        .preview-list {
            display: flex;
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .preview-item {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #ddd;
            flex-shrink: 0;
        }

        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .preview-item .remove-btn {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 24px;
            height: 24px;
            border: none;
            border-radius: 50%;
            background: rgba(200, 0, 0, 0.9);
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-item .remove-btn:hover {
            background: #c00;
        }

        .btn {
            padding: 0.6rem 1.25rem;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }

        .btn-primary {
            background: #0d6efd;
            color: #fff;
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .result-box {
            margin-top: 1.5rem;
            padding: 1rem;
            background: #e8f5e9;
            border-radius: 8px;
            word-break: break-all;
        }

        .result-box a {
            color: #2e7d32;
        }

        .result-box.error {
            background: #ffebee;
            color: #c62828;
        }

        .result-box ul {
            margin: 0.5rem 0 0 1rem;
            padding: 0;
        }

        h1 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }

        .hint {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
<h1>فرم تست (نام + چند عکس)</h1>
<p class="hint">نام را وارد کنید. در باکس عکس یا در کادر توضیحات چند بار Ctrl+V بزنید تا عکس‌ها اضافه شوند. هر عکس را با
    دکمه × می‌توانید حذف کنید.</p>

<form id="testForm">
    <div class="form-group">
        <label for="name">نام</label>
        <input type="text" id="name" name="name" placeholder="نام شما">
    </div>

    <div class="form-group">
        <label for="previewZone">عکس‌ها (Ctrl+V در باکس یا در کادر توضیحات)</label>
        <div id="previewZone" class="preview-zone empty" tabindex="0" aria-live="polite">
            <div class="preview-placeholder">عکس‌ها اینجا نمایش داده می‌شوند (Ctrl+V بزنید یا چند بار paste کنید)</div>
            <div class="preview-list" id="previewList"></div>
        </div>
    </div>

    <div class="form-group">
        <label for="description">توضیحات</label>
        <textarea id="description" name="description" placeholder="متن یا اینجا Ctrl+V بزنید..."></textarea>
    </div>

    <button type="submit" id="submitBtn" class="btn btn-primary" disabled>ذخیره و آپلود</button>
</form>

<div id="resultBox" class="result-box" style="display: none;" aria-live="polite"></div>

<script>
    (function () {
        const form = document.getElementById('testForm');
        const previewZone = document.getElementById('previewZone');
        const previewList = document.getElementById('previewList');
        const description = document.getElementById('description');
        const submitBtn = document.getElementById('submitBtn');
        const resultBox = document.getElementById('resultBox');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        let files = [];

        function addFile(file) {
            files.push(file);
            renderPreviews();
            submitBtn.disabled = files.length === 0;
        }

        function removeFile(index) {
            files.splice(index, 1);
            renderPreviews();
            submitBtn.disabled = files.length === 0;
        }

        function renderPreviews() {
            previewList.innerHTML = '';
            if (files.length === 0) {
                previewZone.classList.add('empty');
                return;
            }
            previewZone.classList.remove('empty');
            files.forEach(function (file, i) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = 'پیش‌نمایش ' + (i + 1);
                img.onload = function () {
                    URL.revokeObjectURL(img.src);
                };
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'remove-btn';
                btn.innerHTML = '×';
                btn.setAttribute('aria-label', 'حذف عکس');
                btn.addEventListener('click', function () {
                    removeFile(i);
                });
                div.appendChild(img);
                div.appendChild(btn);
                previewList.appendChild(div);
            });
        }

        function handlePaste(e) {
            const items = e.clipboardData?.items;
            if (!items) return;
            for (let i = 0; i < items.length; i++) {
                if (items[i].type.indexOf('image') !== -1) {
                    e.preventDefault();
                    const file = items[i].getAsFile();
                    if (file) addFile(file);
                    return;
                }
            }
        }

        description.addEventListener('paste', handlePaste);
        previewZone.addEventListener('paste', handlePaste);

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            if (files.length === 0) return;
            submitBtn.disabled = true;
            resultBox.style.display = 'none';
            resultBox.classList.remove('error');

            const formData = new FormData();
            formData.append('_token', csrfToken);
            formData.append('name', document.getElementById('name').value.trim());
            formData.append('description', description.value.trim());
            files.forEach(function (file) {
                formData.append('images[]', file);
            });

            try {
                const res = await fetch('{{ url("/test/upload") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                });
                const data = await res.json();
                resultBox.style.display = 'block';
                if (data.urls && data.urls.length > 0) {
                    if (window.Livewire) {
                        Livewire.dispatch('setUploadedImages', {urls: data.urls});
                    }
                    let html = '<strong>ذخیره شد.</strong><br>';
                    if (data.name) html += 'نام: ' + escapeHtml(data.name) + '<br>';
                    html += 'آدرس عکس‌ها:<ul>';
                    data.urls.forEach(function (url) {
                        html += '<li><a href="' + url + '" target="_blank" rel="noopener">' + url + '</a></li>';
                    });
                    html += '</ul>';
                    if (data.description) html += 'توضیحات: ' + escapeHtml(data.description);
                    resultBox.innerHTML = html;
                    resultBox.classList.remove('error');
                    files = [];
                    renderPreviews();
                    submitBtn.disabled = true;
                    form.reset();
                } else {
                    resultBox.textContent = data.message || 'خطا در آپلود';
                    resultBox.classList.add('error');
                }
            } catch (err) {
                resultBox.style.display = 'block';
                resultBox.textContent = 'خطا: ' + (err.message || 'اتصال برقرار نشد');
                resultBox.classList.add('error');
            }
            submitBtn.disabled = files.length === 0;
        });

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

    })();
</script>
</body>
</html>
