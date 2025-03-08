@extends('admin.layouts.app')

@section('titre', 'cms | header & footer')

@push('scripts_head')
    <script src="https://unpkg.com/micromodal/dist/micromodal.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
@endpush

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
@endpush

@section('content')
    <div class="container border border-black p-4">
        <div class="row page">
            <fieldset class="border border-black p-3 mb-4">
                <legend class="float-none w-auto px-3">Header</legend>
                <div class="form-floating col-2 ms-auto">
                    <input value="{{ $header_element['header.button']->content }}" name="header.button" type="text"
                           class="form-control border-0 rounded-0 bg-black text-white" id="header.button"
                           placeholder="button">
                    <label for="header.button" class="text-white">Bouton</label>
                </div>
            </fieldset>

            <fieldset class="border border-black p-3">
                <legend class="float-none w-auto px-3">Footer</legend>
                <div class="row justify-content-between">
                    <div class="col-auto mb-3">
                        <fieldset class="border border-black p-3">
                            <legend class="float-none w-auto px-3 fs-5">Contact</legend>
                            <ul id="list">
                                @foreach(explode(',', $footer_element['footer.contacts']->content) as $contact)
                                    <li>
                                        <span>{{ $contact }}</span>
                                        <input type="text" value="{{ $contact }}">
                                    </li>
                                @endforeach
                                <li data-new="true">
                                    <span>ajouter</span>
                                    <input type="text">
                                </li>
                            </ul>
                        </fieldset>
                    </div>
                    <div class="col-auto mb-3">
                        <fieldset class="border border-black p-3">
                            <legend class="float-none w-auto px-3 fs-5">Politique, Conditions, FAQ</legend>
                            <ul>
                                <li><a style="cursor: pointer" data-micromodal-trigger="pcModal">Politique de
                                        confidentialité</a></li>
                                <li><a style="cursor: pointer" data-micromodal-trigger="cguModal">Conditions
                                        d'utilisation</a></li>
                                <li><a style="cursor: pointer" data-micromodal-trigger="faqModal">FAQ</a></li>
                            </ul>
                        </fieldset>
                    </div>
                    <div class="col-2">
                        <div class="form-floating">
                            <input value="{{ $footer_element['footer.button']->content }}" type="text" class="form-control border-0 rounded-0 bg-black text-white"
                                   id="footer.button" name="footer.button" placeholder="button">
                            <label for="footer.button" class="text-white">Bouton</label>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-floating">
                        <input value="{{ $footer_element['footer.copyright']->content }}" type="text" class="form-control border-black rounded-0 bg-white fs-5 mb-3"
                               id="footer.copyright" name="footer.copyright" placeholder="Copyright">
                        <label for="footer.copyright" class="">Copyright</label>
                    </div>
                </div>
            </fieldset>

        </div>
        <button class="save-cms btn btn-success fs-4 text-white" data-micromodal-trigger="save-modal"><i class="bi bi-check-all"></i></button>
    </div>

    <div class="modal micromodal-slide" id="save-modal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <div class="modal__content" id="delete-modal-content">
                    Sauvegarder les modifications
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-success" id="confirm-save" aria-label="Close this dialog">Confirmer</button>
                </footer>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide " id="pcModal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-75" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <header class="modal__header">
                    Politique de confidentialité
                </header>
                <div class="modal__content" id="delete-modal-content">
                    <div id="pcEditor" class="editor">
                        {!! $footer_element['footer.politique']->content !!}
                    </div>
                    <input type="hidden" name="description" id="description">
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-success" id="confirm-save" aria-label="Close this dialog">Ok</button>
                </footer>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide " id="cguModal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-75" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <header class="modal__header">
                    Conditions d'utilisation
                </header>
                <div class="modal__content" id="delete-modal-content">
                    <div id="cguEditor" class="editor">
                        {!! $footer_element['footer.condition']->content !!}
                    </div>
                    <input type="hidden" name="description" id="description">
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-success" id="confirm-save" aria-label="Close this dialog">Ok</button>
                </footer>
            </div>
        </div>
    </div>

    <div class="modal micromodal-slide " id="faqModal" aria-hidden="true">
        <div class="modal__overlay" tabindex="-1" data-micromodal-close>
            <div class="modal__container w-75" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title">
                <header class="modal__header">
                    FAQ
                </header>
                <div class="modal__content" id="delete-modal-content">
                    <div id="faq-input">
                        <input class="form-input form-control" type="text" id="question" placeholder="Entrer question">
                        <textarea class="form-text form-control" id="answer" placeholder="Entrer réponse"></textarea>
                        <button class="mt-2 btn btn-dark" id="add-faq">Ajouter</button>
                        <div class="mt-2" id="faq-list"></div>
                    </div>
                </div>
                <footer class="modal__footer">
                    <button class="modal__btn" data-micromodal-close aria-label="Close this dialog">Annuler</button>
                    <button class="modal__btn btn-success" id="confirm-save" aria-label="Close this dialog">Ok</button>
                </footer>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        MicroModal.init();

        let pcQuill = new Quill('#pcEditor', {
            theme: 'snow',
        });
        let cguQuill = new Quill('#cguEditor', {
            theme: 'snow',
        });

        const csrfToken = '{{csrf_token()}}';

        // contact list
        let list = document.getElementById("list");
        let listItems = list.querySelectorAll("li");
        let inputs = list.querySelectorAll("input");

        for (let i = 0; i < listItems.length; i++) {
            setEventListener(listItems[i], inputs[i]);
        }

        function editItem(eventInput, object) {
            if (!object) object = this;
            console.log(object);
            if (!(object instanceof Window)) {
                object.className = "edit";
                let inputField = object.querySelector("input");
                inputField.focus();
                inputField.setSelectionRange(0, inputField.value.length);
            }
        }

        function blurInput(event) {
            this.parentNode.className = "";

            if (this.value === "") {
                if (this.parentNode.getAttribute("data-new")) addChild();
                list.removeChild(this.parentNode);

            } else {
                this.previousElementSibling.innerHTML = this.value;

                if (this.parentNode.getAttribute("data-new")) {
                    this.parentNode.removeAttribute("data-new");
                    addChild();
                }

            }

        }

        function keyInput(event) {
            if (event.which === 13 || event.which === 9) {
                event.preventDefault();
                this.blur();

                if (!this.parentNode.getAttribute("data-new")) {
                    editItem(null, this.parentNode.nextElementSibling);
                }

            }
        }

        function setEventListener(listItem, input) {
            listItem.addEventListener("click", editItem);
            input.addEventListener("blur", blurInput);
            input.addEventListener("keydown", keyInput);
        }

        function addChild() {
            let entry = document.createElement('li');
            entry.innerHTML = "<span>ajouter</span><input type='text'>";
            entry.setAttribute("data-new", true);
            list.appendChild(entry);
            setEventListener(entry, entry.lastChild);
        }
        // contact list

        function getListContacts() {
            let listItemsCurrent = list.querySelectorAll("li");
            const innerHtmlArray = Array.from(listItemsCurrent).slice(0, -1).map(li => li.innerText);
            return innerHtmlArray.join(',');
        }

        function collectInputsData() {
            const formData = new FormData();

            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    if (input.type === 'checkbox' || input.type === 'radio') {
                        if (input.checked) {
                            formData.append(input.name, input.value);
                        }
                    } else {
                        formData.append(input.name, input.value);
                    }
                }
            });
            return formData;
        }

        function saveUpdate() {
            const formData = collectInputsData();

            formData.append('footer.contacts', getListContacts());

            formData.append('footer.condition', document.getElementById('cguEditor').querySelector('.ql-editor').innerHTML)

            formData.append('footer.faq', storeFaqs());

            // Send the FormData using fetch
            fetch('{{ route('admin.cms.save') }}', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Page mise à jour");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        document.getElementById('confirm-save').addEventListener('click', saveUpdate);

        //faq
        const faqInput = document.getElementById('faq-input');
        const questionInput = document.getElementById('question');
        const answerInput = document.getElementById('answer');
        const addFaqButton = document.getElementById('add-faq');
        const faqList = document.getElementById('faq-list');

        let faqs = [];
        document.addEventListener('DOMContentLoaded', function () {
            const faqsString = '{{ $footer_element['footer.faq']->content }}';
            let pairs = faqsString.split("|||");
            pairs.forEach(pair => {
                let [question, answer] = pair.split("||"); // Destructure question and answer
                const faq = { question, answer }; // Create the faq object
                faqs.push(faq); // Add to the faqs array
            });
            updateFaqList();
        });

        function addFaq() {
            const question = questionInput.value.trim();
            const answer = answerInput.value.trim();

            if (question && answer) {
                const faq = {
                    question,
                    answer
                };

                faqs.push(faq);

                questionInput.value = '';
                answerInput.value = '';

                updateFaqList();
            }
        }

        function updateFaqList() {
            faqList.innerHTML = '';
            faqs.forEach((faq, index) => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `${faq.question} - ${faq.answer}`;
                faqList.appendChild(listItem);
            });
        }

        function storeFaqs() {
            const faqString = faqs.map(faq => `${faq.question}||${faq.answer}`).join('|||');
            console.log(faqString);
            return faqString;
        }

        addFaqButton.addEventListener('click', addFaq);

    </script>
@endpush
