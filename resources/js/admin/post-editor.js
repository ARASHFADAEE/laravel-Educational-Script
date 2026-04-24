import '../../css/admin/post-editor.css';

const escapeHtml = (value) =>
    value
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

const createToolbarButton = ({ label, title, command, value = null, className = '' }) => {
    const button = document.createElement('button');
    button.type = 'button';
    button.className = `local-editor__tool ${className}`.trim();
    button.textContent = label;
    button.title = title;
    button.dataset.command = command;

    if (value) {
        button.dataset.value = value;
    }

    return button;
};

const uploadImage = async (file, uploadUrl) => {
    const formData = new FormData();
    formData.append('file', file);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]')?.content || '');

    const response = await fetch(uploadUrl, {
        method: 'POST',
        body: formData,
    });

    if (!response.ok) {
        throw new Error('خطا در آپلود تصویر');
    }

    return response.json();
};

const createCodeModal = (onSubmit) => {
    const overlay = document.createElement('div');
    overlay.className = 'local-editor__modal';
    overlay.innerHTML = `
        <div class="local-editor__dialog">
            <div class="local-editor__dialog-header">
                <strong>درج نمونه کد</strong>
                <button type="button" class="local-editor__dialog-close">بستن</button>
            </div>
            <div class="local-editor__dialog-body">
                <label>
                    <span>زبان کد</span>
                    <select class="local-editor__dialog-select">
                        <option value="plaintext">متن ساده</option>
                        <option value="php">PHP</option>
                        <option value="javascript">JavaScript</option>
                        <option value="html">HTML</option>
                        <option value="css">CSS</option>
                        <option value="bash">Bash</option>
                        <option value="json">JSON</option>
                        <option value="sql">SQL</option>
                    </select>
                </label>
                <label>
                    <span>کد</span>
                    <textarea class="local-editor__dialog-textarea" rows="12" placeholder="نمونه کد را اینجا وارد کنید"></textarea>
                </label>
            </div>
            <div class="local-editor__dialog-footer">
                <button type="button" class="local-editor__dialog-submit">درج کد</button>
            </div>
        </div>
    `;

    const close = () => overlay.remove();
    const closeButton = overlay.querySelector('.local-editor__dialog-close');
    const submitButton = overlay.querySelector('.local-editor__dialog-submit');
    const language = overlay.querySelector('.local-editor__dialog-select');
    const textarea = overlay.querySelector('.local-editor__dialog-textarea');

    closeButton.addEventListener('click', close);
    overlay.addEventListener('click', (event) => {
        if (event.target === overlay) {
            close();
        }
    });

    submitButton.addEventListener('click', () => {
        if (!textarea.value.trim()) {
            textarea.focus();
            return;
        }

        onSubmit({ language: language.value, code: textarea.value });
        close();
    });

    document.body.appendChild(overlay);
    textarea.focus();
};

const initEditor = (textarea) => {
    const uploadUrl = textarea.dataset.uploadUrl;
    const wrapper = document.createElement('div');
    wrapper.className = 'local-editor';

    const toolbar = document.createElement('div');
    toolbar.className = 'local-editor__toolbar';

    const content = document.createElement('div');
    content.className = 'local-editor__content';
    content.contentEditable = 'true';
    content.dir = 'rtl';
    content.innerHTML = textarea.value || '<p></p>';

    const htmlView = document.createElement('textarea');
    htmlView.className = 'local-editor__html hidden';
    htmlView.rows = 14;

    const status = document.createElement('div');
    status.className = 'local-editor__status';
    status.textContent = 'حالت دیداری فعال است';

    const hiddenFileInput = document.createElement('input');
    hiddenFileInput.type = 'file';
    hiddenFileInput.accept = 'image/*';
    hiddenFileInput.className = 'hidden';

    const buttons = [
        { label: 'پاراگراف', title: 'پاراگراف', command: 'formatBlock', value: 'p' },
        { label: 'تیتر ۲', title: 'تیتر سطح ۲', command: 'formatBlock', value: 'h2' },
        { label: 'تیتر ۳', title: 'تیتر سطح ۳', command: 'formatBlock', value: 'h3' },
        { label: 'بولد', title: 'متن بولد', command: 'bold' },
        { label: 'ایتالیک', title: 'متن ایتالیک', command: 'italic' },
        { label: 'لیست', title: 'لیست نشانه‌دار', command: 'insertUnorderedList' },
        { label: 'شماره‌ای', title: 'لیست شماره‌دار', command: 'insertOrderedList' },
        { label: 'نقل‌قول', title: 'نقل‌قول', command: 'formatBlock', value: 'blockquote' },
        { label: 'لینک', title: 'درج لینک', command: 'link', className: 'local-editor__tool--secondary' },
        { label: 'تصویر', title: 'آپلود تصویر', command: 'image', className: 'local-editor__tool--secondary' },
        { label: 'کد', title: 'درج کد', command: 'code', className: 'local-editor__tool--secondary' },
        { label: 'حذف فرمت', title: 'حذف فرمت', command: 'removeFormat', className: 'local-editor__tool--ghost' },
        { label: 'HTML', title: 'نمای HTML', command: 'toggleHtml', className: 'local-editor__tool--ghost' },
    ];

    let htmlMode = false;

    const syncToTextarea = () => {
        textarea.value = htmlMode ? htmlView.value : content.innerHTML;
    };

    const setStatus = (message) => {
        status.textContent = message;
    };

    const toggleHtmlMode = () => {
        htmlMode = !htmlMode;

        if (htmlMode) {
            htmlView.value = content.innerHTML;
            content.classList.add('hidden');
            htmlView.classList.remove('hidden');
            setStatus('نمای HTML فعال است');
        } else {
            content.innerHTML = htmlView.value;
            htmlView.classList.add('hidden');
            content.classList.remove('hidden');
            setStatus('حالت دیداری فعال است');
        }

        syncToTextarea();
    };

    buttons.forEach((buttonConfig) => {
        const button = createToolbarButton(buttonConfig);
        toolbar.appendChild(button);

        button.addEventListener('click', async () => {
            if (buttonConfig.command !== 'toggleHtml' && htmlMode) {
                toggleHtmlMode();
            }

            content.focus();

            if (buttonConfig.command === 'link') {
                const url = window.prompt('لینک را وارد کنید');
                if (url) {
                    document.execCommand('createLink', false, url);
                    syncToTextarea();
                }
                return;
            }

            if (buttonConfig.command === 'image') {
                hiddenFileInput.click();
                return;
            }

            if (buttonConfig.command === 'code') {
                createCodeModal(({ language, code }) => {
                    const markup = `<pre><code class="language-${language}">${escapeHtml(code)}</code></pre><p></p>`;
                    document.execCommand('insertHTML', false, markup);
                    syncToTextarea();
                });
                return;
            }

            if (buttonConfig.command === 'toggleHtml') {
                toggleHtmlMode();
                return;
            }

            document.execCommand(buttonConfig.command, false, buttonConfig.value);
            syncToTextarea();
        });
    });

    hiddenFileInput.addEventListener('change', async () => {
        const [file] = hiddenFileInput.files || [];
        if (!file || !uploadUrl) {
            return;
        }

        setStatus('در حال آپلود تصویر...');

        try {
            const data = await uploadImage(file, uploadUrl);
            document.execCommand('insertImage', false, data.location);
            syncToTextarea();
            setStatus('تصویر با موفقیت درج شد');
        } catch (error) {
            console.error(error);
            setStatus('آپلود تصویر ناموفق بود');
        } finally {
            hiddenFileInput.value = '';
        }
    });

    content.addEventListener('input', syncToTextarea);
    htmlView.addEventListener('input', syncToTextarea);
    textarea.form?.addEventListener('submit', syncToTextarea);

    textarea.classList.add('hidden');
    textarea.parentNode.insertBefore(wrapper, textarea);
    wrapper.appendChild(toolbar);
    wrapper.appendChild(content);
    wrapper.appendChild(htmlView);
    wrapper.appendChild(status);
    wrapper.appendChild(hiddenFileInput);
};

const boot = () => {
    document.querySelectorAll('[data-local-editor]').forEach((textarea) => initEditor(textarea));
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', boot);
} else {
    boot();
}
