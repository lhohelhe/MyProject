/* resources/js/admin/materi-editor.js */

// Alpine component for Materi creation – handles PDF extraction, displays extracted text as a read‑only "book" view,
// allows clicking on words to define terms via a small pop‑over, keeps a side‑panel of tagged terms,
// and synchronises the hidden input "isi" with the generated HTML (inner content only).

window.materiEditor = function () {
    return {
        // ----- State --------------------------------------------------------
        extracted: false,          // becomes true after PDF extraction
        rawText: '',               // raw extracted text from server
        words: [],                 // [{ text: string, isTerm: bool, definition: string }]
        terms: [],                 // [{ id: number, text: string, definition: string }]
        popover: {
            visible: false,
            x: 0,
            y: 0,
            wordIndex: null,
            definition: ''
        },

        // ----- Computed -----------------------------------------------------
        get popoverStyle() {
            return `top:${this.popover.y}px; left:${this.popover.x}px;`;
        },
        get bookHtml() {
            // Render words with term styling for the read‑only view.
            return this.words.map(w => {
                if (w.isTerm) {
                    const def = w.definition.replace(/"/g, '&quot;');
                    return `<span class="term" data-definisi="${def}">${w.text}</span>`;
                }
                return w.text;
            }).join('');
        },

        // ----- PDF Extraction -----------------------------------------------
        extractPdf() {
            const fileInput = this.$refs.pdf;
            if (!fileInput.files.length) return;
            const formData = new FormData();
            formData.append('pdf', fileInput.files[0]);
            const token = document.querySelector('meta[name="csrf-token"]').content;
            fetch('{{ route('materi.extract-pdf') }}', {
                method: 'POST',
                headers: { 'X‑CSRF‑TOKEN': token },
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    this.rawText = data.text || '';
                    this.extracted = true;
                    this._generateWords();
                    this._syncIsi();
                })
                .catch(err => console.error('PDF extraction failed', err));
        },

        // Split raw text while preserving spaces.
        _generateWords() {
            const parts = this.rawText.split(/(\s+)/);
            this.words = parts.map(p => ({ text: p, isTerm: false, definition: '' }));
        },

        // Sync hidden input with generated HTML.
        _syncIsi() {
            this.$refs.isi.value = this.bookHtml;
        },

        // ----- Term Tagging --------------------------------------------------
        openPopover(event, idx) {
            const word = this.words[idx];
            if (!word || word.text.trim() === '') return; // ignore whitespace tokens
            this.popover.visible = true;
            this.popover.x = event.clientX + 10;
            this.popover.y = event.clientY + 10;
            this.popover.wordIndex = idx;
            this.popover.definition = word.definition || '';
        },
        cancelPopover() {
            this.popover.visible = false;
            this.popover.definition = '';
        },
        addTerm() {
            const idx = this.popover.wordIndex;
            if (idx === null) return;
            const def = this.popover.definition.trim();
            if (!def) return;
            this.words[idx].isTerm = true;
            this.words[idx].definition = def;
            this.terms.push({ id: Date.now() + Math.random(), text: this.words[idx].text, definition: def });
            this.cancelPopover();
            this._syncIsi();
        },
        deleteTerm(termId) {
            const term = this.terms.find(t => t.id === termId);
            if (!term) return;
            const idx = this.words.findIndex(w => w.isTerm && w.text === term.text && w.definition === term.definition);
            if (idx !== -1) {
                this.words[idx].isTerm = false;
                this.words[idx].definition = '';
            }
            this.terms = this.terms.filter(t => t.id !== termId);
            this._syncIsi();
        },
        scrollToTerm(term) {
            this.$nextTick(() => {
                const container = this.$refs.book;
                const escaped = term.definition.replace(/"/g, '\\"');
                const selector = `span.term[data-definisi="${escaped}"]`;
                const el = container.querySelector(selector);
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    el.classList.add('bg-yellow-200');
                    setTimeout(() => el.classList.remove('bg-yellow-200'), 1500);
                }
            });
        }
    };
};
