
<x-app-layout>
    <div class="py-12">
        <div class="flex flex-col max-w-7xl mx-auto bg-white">
            <div class="post w-48 self-start mb-4">
                <span>User Name</span>
                <div>Hello, goodbye. </div>
            </div>

            <div class="post w-48 self-end mb-4">
                <span>User Name</span>
                <div>Yeah.  </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto bg-white">
            <form method="post" action="#">
                <input type="text" name="post" />
                <input type="submit" value="投稿" />
            </form>
        </div>
    </div>
</x-app-layout>