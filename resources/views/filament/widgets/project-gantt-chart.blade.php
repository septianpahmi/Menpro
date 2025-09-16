<x-filament-widgets::widget>
    <x-filament::section>
        <h2 class="text-xl font-bold mb-4">Project Timeline (Gantt Chart)</h2>

        <div id="gantt"></div>

        <script>
            document.addEventListener("livewire:load", function() {
                const tasks = @json($this->getTasks());

                console.log("Loaded tasks:", tasks);

                setTimeout(() => {
                    new Gantt("#gantt", tasks, {
                        view_mode: 'Day',
                        date_format: 'YYYY-MM-DD',
                        custom_popup_html: function(task) {
                            return `
                                <div class="p-2">
                                    <h5 class="font-bold">${task.name}</h5>
                                    <p>Start: ${task.start}</p>
                                    <p>End: ${task.end}</p>
                                </div>
                            `;
                        }
                    });
                }, 200);
            });
        </script>
    </x-filament::section>
</x-filament-widgets::widget>
