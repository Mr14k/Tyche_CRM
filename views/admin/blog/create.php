<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="h3 font-monospace text-light m-0">Create & Publish New Blog Article</h2>
        <p class="text-secondary small m-0">Write rich, decorated SEO content using the Rich Text Editor</p>
    </div>
    <a href="<?= Url::to('/admin/blog') ?>" class="btn btn-outline-secondary btn-sm text-light font-monospace">
        <i class="bi bi-arrow-left me-1"></i> Back to Blog List
    </a>
</div>

<form action="<?= Url::to('/admin/blog') ?>" method="POST" id="blogForm">
    <input type="hidden" name="_token" value="<?= Security::csrfToken() ?>">
    <input type="hidden" name="content" id="blogContentHidden">

    <div class="row g-4">
        <!-- Main Content Area with Rich Text Editor -->
        <div class="col-lg-8">
            <div class="card-custom p-4 mb-4">
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Article Title *</label>
                    <input type="text" name="title" class="form-control form-control-lg font-heading fw-bold" placeholder="e.g. Master AEO & GEO: How ChatGPT & Perplexity Surface Brands in 2026" required>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Short Excerpt / Summary (Optional)</label>
                    <textarea name="summary" class="form-control" rows="2" placeholder="Brief 1-2 sentence summary displayed on blog list cards..."></textarea>
                </div>

                <!-- RICH TEXT EDITOR TOOLBAR -->
                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small d-flex justify-content-between align-items-center">
                        <span>Rich Text Editor & Article Decorator *</span>
                        <button type="button" class="btn btn-sm btn-outline-info py-0 font-monospace" id="toggleHtmlModeBtn"><i class="bi bi-code-slash"></i> View HTML Source</button>
                    </label>

                    <div class="rich-editor-wrapper rounded-3 border" style="border-color: rgba(243,238,226,0.2) !important; background: #0F1620;">
                        <!-- WYSIWYG Toolbar -->
                        <div class="editor-toolbar p-2 border-bottom d-flex flex-wrap gap-1 align-items-center" style="background: #161F2B; border-color: rgba(243,238,226,0.14) !important;">
                            <!-- Headings Select -->
                            <select class="form-select form-select-sm font-monospace" id="formatBlockSelect" style="width: 130px; background: #0F1620; color: #F3EEE2;">
                                <option value="p">Paragraph</option>
                                <option value="h1">Heading 1</option>
                                <option value="h2">Heading 2</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                                <option value="blockquote">Blockquote</option>
                                <option value="pre">Code Block</option>
                            </select>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Text Formatting -->
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="bold" title="Bold (Ctrl+B)"><i class="bi bi-type-bold"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="italic" title="Italic (Ctrl+I)"><i class="bi bi-type-italic"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="underline" title="Underline (Ctrl+U)"><i class="bi bi-type-underline"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="strikeThrough" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Colors -->
                            <label class="btn btn-outline-light btn-sm px-2 m-0 d-flex align-items-center gap-1" title="Text Color">
                                <i class="bi bi-palette-fill text-warning"></i>
                                <input type="color" id="foreColorPicker" style="width:0; height:0; opacity:0; padding:0; border:0;" value="#F3EEE2">
                            </label>

                            <label class="btn btn-outline-light btn-sm px-2 m-0 d-flex align-items-center gap-1" title="Background Highlight">
                                <i class="bi bi-highlighter text-info"></i>
                                <input type="color" id="hiliteColorPicker" style="width:0; height:0; opacity:0; padding:0; border:0;" value="#4338CA">
                            </label>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Alignment -->
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="justifyLeft" title="Align Left"><i class="bi bi-text-left"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="justifyCenter" title="Align Center"><i class="bi bi-text-center"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="justifyRight" title="Align Right"><i class="bi bi-text-right"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="justifyFull" title="Justify"><i class="bi bi-justify"></i></button>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Lists -->
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="insertUnorderedList" title="Bulleted List"><i class="bi bi-list-ul"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="insertOrderedList" title="Numbered List"><i class="bi bi-list-ol"></i></button>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Inserts -->
                            <button type="button" class="btn btn-outline-light btn-sm px-2" id="insertLinkBtn" title="Insert Link"><i class="bi bi-link-45deg"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2" id="insertImageBtn" title="Insert Image URL"><i class="bi bi-image"></i></button>
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-btn" data-cmd="insertHorizontalRule" title="Insert Line Divider"><i class="bi bi-hr"></i></button>

                            <div class="vr bg-secondary mx-1" style="height: 24px;"></div>

                            <!-- Clear & Undo -->
                            <button type="button" class="btn btn-outline-light btn-sm px-2 editor-cmd" data-cmd="removeFormat" title="Clear Formatting"><i class="bi bi-eraser"></i></button>
                        </div>

                        <!-- Editable Content Window -->
                        <div id="richEditorArea" contenteditable="true" class="p-4" style="min-height: 420px; outline: none; color: #F3EEE2; background: #0F1620; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; line-height: 1.7;">
                            <h2>Introduction to AEO & GEO Search Optimization</h2>
                            <p>As AI search engines like <strong>ChatGPT 4o</strong>, <strong>Perplexity AI</strong>, and <strong>Google AI Overviews</strong> transform digital marketing, brands must adapt beyond traditional 2020 keyword stuffing...</p>
                            <ul>
                                <li><strong>Answer Engine Optimization (AEO):</strong> Formatting content to be surfaced directly as zero-click answers.</li>
                                <li><strong>Generative Engine Optimization (GEO):</strong> Optimizing brand citations inside LLM knowledge graphs.</li>
                            </ul>
                        </div>

                        <!-- Raw HTML Textarea Mode (Hidden by Default) -->
                        <textarea id="rawHtmlArea" class="form-control font-monospace p-3 d-none" style="min-height: 420px; background: #0F1620; color: #38BDF8; border: none; font-size: 13px;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">
            <div class="card-custom p-4 mb-4">
                <h5 class="h6 font-monospace text-warning mb-3">Publishing Settings</h5>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Publication Status</label>
                    <select name="status" class="form-select font-monospace">
                        <option value="published" selected>Published Immediately</option>
                        <option value="draft">Save as Draft</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Category</label>
                    <select name="category_id" class="form-select font-monospace">
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= Security::e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-warning font-monospace small">Featured Cover Image URL</label>
                    <input type="url" name="featured_image" class="form-control font-monospace small" value="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=800&q=80">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="isFeaturedCheck" value="1">
                    <label class="form-check-label text-light small fw-bold" for="isFeaturedCheck">
                        Feature this article on Homepage & Hero Banner
                    </label>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="is_sticky" id="isStickyCheck" value="1">
                    <label class="form-check-label text-light small fw-bold" for="isStickyCheck">
                        Pin to top of Blog Directory
                    </label>
                </div>

                <button type="submit" class="btn btn-gold w-100 py-3 font-monospace fw-bold">
                    <i class="bi bi-send-fill me-1"></i> Publish Article Now
                </button>
            </div>
        </div>
    </div>
</form>

<!-- RICH EDITOR SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const editor = document.getElementById('richEditorArea');
    const rawHtml = document.getElementById('rawHtmlArea');
    const hiddenContent = document.getElementById('blogContentHidden');
    const form = document.getElementById('blogForm');
    const toggleHtmlBtn = document.getElementById('toggleHtmlModeBtn');

    // Execute Formatting Command
    document.querySelectorAll('.editor-btn, .editor-cmd').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const cmd = this.getAttribute('data-cmd');
            document.execCommand(cmd, false, null);
            editor.focus();
        });
    });

    // Format Block (Headings, Paragraphs, Blockquote)
    document.getElementById('formatBlockSelect').addEventListener('change', function() {
        const val = this.value;
        document.execCommand('formatBlock', false, val);
        editor.focus();
    });

    // Fore Color
    document.getElementById('foreColorPicker').addEventListener('input', function() {
        document.execCommand('foreColor', false, this.value);
        editor.focus();
    });

    // Hilite Color
    document.getElementById('hiliteColorPicker').addEventListener('input', function() {
        document.execCommand('hiliteColor', false, this.value);
        editor.focus();
    });

    // Insert Link
    document.getElementById('insertLinkBtn').addEventListener('click', function() {
        const url = prompt('Enter Hyperlink URL:', 'https://');
        if (url) {
            document.execCommand('createLink', false, url);
        }
    });

    // Insert Image
    document.getElementById('insertImageBtn').addEventListener('click', function() {
        const url = prompt('Enter Image URL:', 'https://images.unsplash.com/');
        if (url) {
            document.execCommand('insertImage', false, url);
        }
    });

    // Toggle Raw HTML Mode
    let isHtmlMode = false;
    toggleHtmlBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (!isHtmlMode) {
            rawHtml.value = editor.innerHTML;
            editor.classList.add('d-none');
            rawHtml.classList.remove('d-none');
            toggleHtmlBtn.innerHTML = '<i class="bi bi-eye"></i> View Visual Editor';
            isHtmlMode = true;
        } else {
            editor.innerHTML = rawHtml.value;
            rawHtml.classList.add('d-none');
            editor.classList.remove('d-none');
            toggleHtmlBtn.innerHTML = '<i class="bi bi-code-slash"></i> View HTML Source';
            isHtmlMode = false;
        }
    });

    // On Submit: Sync editor content to hidden input
    form.addEventListener('submit', function() {
        if (isHtmlMode) {
            hiddenContent.value = rawHtml.value;
        } else {
            hiddenContent.value = editor.innerHTML;
        }
    });
});
</script>
