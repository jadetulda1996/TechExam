<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto p-4 shadow-md sm:rounded-lg">
                    <div class="mb-4 flex w-full flex-row-reverse justify-between">
                        <div>
                            <label for="table-search" class="sr-only">Search</label>
                            <div class="relative mt-1">
                                <div
                                    class="rtl:inset-r-0 pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3">
                                    <svg class="h-4 w-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="table-search"
                                    class="block w-80 rounded-lg border border-gray-300 bg-gray-50 ps-10 pt-2 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                    placeholder="Search for items">
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="mb-4 rounded-lg bg-green-50 p-4 text-sm text-green-800 dark:bg-gray-800 dark:text-green-400"
                                role="alert">
                                <span class="font-medium">Success!</span> {{ session('success') }}
                            </div>
                        @endif
                    </div>
                    <table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Company
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Phone
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($contacts))

                                @foreach ($contacts as $contact)
                                    <tr
                                        class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">
                                        <th scope="row"
                                            class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                                            {{ $contact->name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $contact->company_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->phone_number }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $contact->email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('contact.edit', ['contact' => $contact->id]) }}"
                                                class="font-medium text-blue-600 hover:underline dark:text-blue-500">Edit</a>
                                            |
                                            <button
                                                class="deleteContact font-medium text-red-600 hover:underline dark:text-red-500"
                                                onclick="deleteContact({{ $contact->id }})"
                                                data-modal-target="delete-contact-modal">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="pt-2 text-center italic">No Contacts saved.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="mt-6 p-4">
                        {{ $contacts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-contact-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
        <div class="relative m-auto mt-[150px] max-h-full w-full max-w-2xl p-4">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between rounded-t p-4 dark:border-gray-600 md:p-5">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Are you sure you want to DELETE?
                    </h3>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center rounded-b border-gray-200 p-4 dark:border-gray-600 md:p-5">
                    <form method="POST" action="{{ route('contact.destroy') }}">
                        @csrf
                        @method('DELETE')
                        <input type="text" name="contact_id" id="contact-id">
                        <button data-modal-hide="delete-contact-modal" type="submit"
                            class="rounded-lg bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Yes
                        </button>
                        <button data-modal-hide="delete-contact-modal" type="button"
                            class="ms-3 rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white dark:focus:ring-gray-600">No</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $('#table-search').on('keyup', function() {
        $value = $(this).val();

        $.ajax({
            type: 'get',
            url: '{{ route('contact.search') }}',
            data: {
                'search': $value
            },
            success: function(result) {

                $data = result.data
                $output = '';
                console.log($data);
                if ($data.length > 0) {
                    $data.forEach(element => {
                        $output +=
                            '<tr class="border-b bg-white hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-600">' +
                            '<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">' +
                            element.name + '</th>' +
                            '<td class="px-6 py-4">' + element.company_name + '</td>' +
                            '<td class = "px-6 py-4" > ' + element.phone_number + '</td>' +
                            '<td class="px-6 py-4">' + element.email + '</td>' +
                            '<td class="px-6 py-4">' +
                            '<a href="contacts/edit/' + element.id +
                            '" class="font-medium text-blue-600 hover:underline dark:text-blue-500">Edit</a> | ' +
                            '<button class="deleteContact font-medium text-red-600 hover:underline :text-red-500"' +
                            'onclick = "deleteContact(' + element.id + ')"' +
                            'data-modal-target="delete-contact-modal"> Delete </button>' +
                            '</td></tr>';
                    });

                    $('tbody').html($output);
                } else
                    $('tbody').html(
                        '<tr><td colspan="5" class="pt-2 text-center italic">No Contacts saved.</td></tr>'
                    );
            }
        });
    });

    function deleteContact(contact_id) {
        var input = document.getElementById('contact-id');
        var modal = document.getElementById('delete-contact-modal');
        input.value = contact_id;
        modal.classList.remove('hidden');
    }
</script>
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'csrftoken': '{{ csrf_token() }}'
        }
    });
</script>
