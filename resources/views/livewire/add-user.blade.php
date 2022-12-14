<div>
    @if($message = session('success_message'))
        <div class="py-4 px-2 bg-green-600 text-white rounded my-4">
            <p>{{$message}}</p>
        </div>
    @endif
    <form wire:submit.prevent="submit" enctype="multipart/form-data">
        <div class="grid grid-cols-6 gap-6">
            <x-input
                wire:model="name"
                label="Name"
                :required="true"
                placeholder="Instructor"
            />
            <x-input
                wire:model="email"
                label="Email"
                :required="true"
                placeholder="Instructor"
            />
            <div class="col-span-6 sm:col-span-2">
                <label for="department" class="block text-sm font-medium leading-5 text-gray-700">Department</label>
                <select wire:model="department"
                        id="department"
                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    <option value="human_resources">Human Resources</option>
                    <option value="marketing">Marketing</option>
                    <option value="information_technology">Information Technology</option>
                </select>
            </div>

            <x-input
                wire:model="title"
                label="Title"
                :required="true"
                placeholder="Instructor"
            />

            <div class="col-span-6">
                <label class="block text-sm leading-5 font-medium text-gray-700 mb-2">
                    Photo
                </label>
                <div class="flex flex-items-center">
                    <div class="flex-shrink-0 h-10 w-10 mr-4">
                        @if($photo)
                            <img class="h-10 w-10 rounded-full"
                                 src="{{$photo->temporaryUrl()}}"
                                 alt="">
                        @else
                            <svg class="h-10 w-10 text-gray-300 rounded-full" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        @endif

                    </div>
                    <div>
                        <div wire:loading wire:target="photo">
                            <x-loading class="mr-4" />
                        </div>
                        <input type="file" wire:model="photo"
                               @error('photo') class="border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red " @enderror">

                        @error('photo')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-span-6">
                <label class="block text-sm leading-5 font-medium text-gray-700 mb-2">
                    Application
                </label>
                <div>
                    @if($document)
                        <div class="flex-shrink-0 h-10 w-5 mr-4">
                            <x-document-icon />
                        </div>
                    @endif
                </div>
                <div wire:loading wire:target="document">
                    <x-loading class="mr-4" />
                </div>
                <input type="file" wire:model="document" @error('document') class="border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red" @enderror>
                @error('document')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="status" class="block text-sm font-medium leading-5 text-gray-700">Status</label>
                <select wire:model="status"
                        id="status"
                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>

            <div class="col-span-6 sm:col-span-2">
                <label for="role" class="block text-sm font-medium leading-5 text-gray-700">Role</label>
                <select wire:model="role"
                        id="role"
                        class="mt-1 block form-select w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5">
                    <option value="admin">Admin</option>
                    <option value="manager">Manager</option>
                    <option value="member">Team Member</option>
                </select>
            </div>


        </div>

        <div class="mt-8 border-t border-gray-200 pt-5">
            <div class="flex justify-end">
                <div wire:loading wire:target="submit">
                    <x-loading class="mr-4" />
                </div>
                <span class="inline-flex rounded-md shadow-sm">
                    <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                        Add Team Member
                    </button>
                </span>
            </div>
        </div>
    </form>

</div>
