@extends('layouts.app')

@section('content')
    <div x-data="feedbackForm()" class="space-y-6">
        <<div class="rounded-lg shadow-md p-3 bg-white/20 backdrop-blur-2xl">
            <p class="font-semibold text-white text-sm mb-3">Harap pilih workshop sebelum menambahkan feedback</p>

            <div class="relative" x-data="{
                open: false,
                search: '',
                workshops: [],
                selectedWorkshop: null,
                loading: false,
            
                searchWorkshops() {
                    if (this.search.length < 2) {
                        this.workshops = [];
                        this.open = false;
                        return;
                    }
            
                    this.loading = true;
                    fetch(`{{ route('feedback.search') }}?q=${encodeURIComponent(this.search)}`)
                        .then(response => response.json())
                        .then(data => {
                            this.workshops = data;
                            this.open = true;
                            this.loading = false;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            this.loading = false;
                        });
                },
            
                selectWorkshop(workshop) {
                    this.selectedWorkshop = workshop;
                    this.search = workshop.title;
                    this.open = false;
                    // Update parent component
                    this.$dispatch('workshop-selected', workshop);
                }
            }">
                <div class="relative">
                    <input type="text" x-model="search" @input.debounce.300ms="searchWorkshops()" @click="open = true"
                        placeholder="Harap ketikan judul workshop..."
                        class="w-full px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <div x-show="loading" class="absolute right-3 top-1/2 transform -translate-y-1/2">
                        <div class="animate-spin rounded-full h-4 w-4 border-2 border-white border-t-transparent"></div>
                    </div>
                </div>

                <div x-show="open && workshops.length > 0" x-transition @click.away="open = false"
                    class="absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-y-auto">
                    <template x-for="workshop in workshops" :key="workshop.id">
                        <div @click="selectWorkshop(workshop)"
                            class="px-4 py-2 hover:bg-gray-100 cursor-pointer border-b border-gray-100 last:border-b-0">
                            <span x-text="workshop.title" class="text-gray-800"></span>
                        </div>
                    </template>
                </div>

                <div x-show="selectedWorkshop" class="mt-2 p-2 bg-green-100 rounded border-l-4 border-green-500">
                    <p class="text-green-700 text-sm">
                        <span class="font-semibold">Workshop terpilih:</span>
                        <span x-text="selectedWorkshop?.title"></span>
                    </p>
                </div>
            </div>
    </div>

    <div class="flex justify-end items-center">
        <x-gradient-button type="button" @click="addQuestion()">Tambah Pertanyaan +
        </x-gradient-button>
    </div>

    <form action="{{ route('feedback.store') }}" method="POST" id="feedback-form">
        @csrf
        <input type="hidden" name="workshop_id" :value="workshopId">

        <template x-for="(question, index) in questions" :key="question.id">
            <div class="rounded-xl shadow-md p-4 mt-5 bg-white/15 backdrop-blur-2xl">
                <div class="flex w-full md:flex-row flex-col-reverse justify-between items-start mb-5 gap-5">
                    <div class="flex-1">
                        <label :for="'question_' + question.id" class="block text-white text-sm font-medium mb-2">
                            Pertanyaan <span x-text="index + 1"></span>
                        </label>
                        <input type="text" :name="'questions[' + index + '][question]'" :id="'question_' + question.id"
                            x-model="question.question" placeholder="Masukkan pertanyaan..." required
                            class="w-full px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="flex justify-end items-center gap-3 ">

                        <div class="md:w-48 w-auto">
                            <label :for="'type_' + question.id" class="block text-white text-sm font-medium mb-2">
                                Type
                            </label>
                            <select :name="'questions[' + index + '][type]'" :id="'type_' + question.id"
                                x-model="question.type" required
                                class="w-full px-4 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option class="text-black" value="free_text">Free Text</option>
                                <option class="text-black" value="multiple_choice">Multiple Choice</option>
                            </select>
                        </div>

                        <button type="button" @click="removeQuestion(index)" x-show="questions.length > 1"
                            class="mt-7 p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-show="question.type === 'multiple_choice'" x-transition class="mt-4">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h4 class="text-white font-medium sm:block hidden">Pilihan Jawaban:</h4>
                            <button type="button" @click="addOption(index)"
                                class="px-3 py-1 w-full sm:w-auto  bg-green-500 backdrop-blur-xl shadow-md text-white text-sm rounded hover:bg-green-600">
                                + Tambah Pilihan
                            </button>
                        </div>

                        <template x-for="(option, optionIndex) in question.options" :key="optionIndex">
                            <div class="flex items-center overflow-auto w-full  gap-3">
                                <input class="sm:block hidden" type="radio" :name="'preview_' + question.id" disabled
                                    class="text-blue-500">

                                <input type="text" :name="'questions[' + index + '][options][' + optionIndex + ']'"
                                    x-model="option.text" placeholder="Masukkan pilihan jawaban..."
                                    class="flex-1 px-3 py-2 bg-white/10 backdrop-blur-sm border border-white/20 rounded text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <button type="button" @click="removeOption(index, optionIndex)"
                                    x-show="question.options.length > 2"
                                    class="p-1 bg-red-500 text-white rounded hover:bg-red-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>

        <div class="flex justify-end mt-5 items-center">
            <x-gradient-button type="submit">
                Submit
            </x-gradient-button>
        </div>
    </form>
    </div>

    <script>
        function feedbackForm() {
            return {
                workshopId: null,
                questions: [{
                    id: Date.now(),
                    question: '',
                    type: 'free_text',
                    options: [{
                            text: ''
                        },
                        {
                            text: ''
                        }
                    ]
                }],

                addQuestion() {
                    this.questions.push({
                        id: Date.now() + Math.random(),
                        question: '',
                        type: 'free_text',
                        options: [{
                                text: ''
                            },
                            {
                                text: ''
                            }
                        ]
                    });
                },

                removeQuestion(index) {
                    if (this.questions.length > 1) {
                        this.questions.splice(index, 1);
                    }
                },

                addOption(questionIndex) {
                    this.questions[questionIndex].options.push({
                        text: ''
                    });
                },

                removeOption(questionIndex, optionIndex) {
                    if (this.questions[questionIndex].options.length > 2) {
                        this.questions[questionIndex].options.splice(optionIndex, 1);
                    }
                }
            }
        }

        Alpine.store('feedbackData', {
            workshopId: null
        });
    </script>
@endsection
