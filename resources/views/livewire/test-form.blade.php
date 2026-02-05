<div>
    <!DOCTYPE html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>تست فرم و آپلود چند عکس</title>
        <style>
            #miniUploader{
                position:fixed; /* ثابت روی صفحه */
                bottom:10px; /* فاصله از پایین */
                right:400px;  /* فاصله از راست */
                width:300px;
                height:290px;
                background:#fff;
                border:1px solid #ccc;
                border-radius:5px;
                padding:5px;
                box-shadow:0 0 5px rgba(0,0,0,0.2);
                z-index:9999;
                display:flex;
                flex-direction:column;
                font-family:Tahoma,sans-serif;
                font-size:12px;
                overflow:hidden;
            }

            #miniUploader .preview-zone{
                flex:1;
                border:1px dashed #ccc;
                margin-bottom:3px;
                overflow-x:auto;
                display:flex;
                flex-wrap:wrap;
                gap:2px;
                min-height:50px;
            }

            #miniUploader .preview-zone.empty .preview-placeholder{
                display:block;
                font-size:10px;
                color:#999;
            }

            #miniUploader .preview-list .preview-item{
                width:30px;
                height:30px;
                position:relative;
            }

            #miniUploader .preview-item img{
                width:100%;
                height:100%;
                object-fit:cover;
            }

            #miniUploader .remove-btn{
                position:absolute;
                top:0;
                left:0;
                width:14px;
                height:14px;
                font-size:10px;
                background:rgba(200,0,0,0.8);
                color:#fff;
                border:none;
                border-radius:50%;
                display:flex;
                justify-content:center;
                align-items:center;
                cursor:pointer;
            }

            #miniUploader textarea{
                width:100%;
                height:30px;
                resize:none;
                font-size:12px;
                margin-bottom:3px;
            }

            #miniUploader .btn{
                width:100%;
                padding:2px;
                font-size:12px;
                border-radius:3px;
            }

            #miniUploader .btn-primary{
                background:#0d6efd;
                color:#fff;
            }

            #miniUploader .btn-primary:disabled{
                opacity:0.6;
                cursor:not-allowed;
            }
        </style>

    </head>
    <body>
    <div id="miniUploader">
        <form id="testForm">
            <div class="form-group" style="display:none">
                <label for="name">نام</label>
                <input type="text" id="name" name="name" placeholder="نام شما">
            </div>

            <div class="form-group">
                <div id="previewZone" class="preview-zone empty" tabindex="0" aria-live="polite">
                    <div class="preview-placeholder">Ctrl+V برای افزودن عکس</div>
                    <div class="preview-list" id="previewList"></div>
                </div>
            </div>

            <div class="form-group">
                <textarea id="description" name="description" placeholder="توضیحات..." style="width:100%;height:40px;"></textarea>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary" disabled>آپلود</button>
        </form>
    </div>

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
                            Livewire.dispatch('setUploadedData', {
                                urls: data.urls,
                                description: description.value.trim()
                            });
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
</div>
