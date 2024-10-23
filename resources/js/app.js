import './bootstrap';
import '../css/app.css';


import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueApexCharts from "vue3-apexcharts";
import PrimeVue from 'primevue/config';
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {

//My Design System with Tailwind
        const MyDesignSystem = {
            inputtext: {
                root: ({ props: InputTextProps, context: InputTextContext }) => ({
                    class: [
                        'm-0',
                        'font-sans text-gray-600 dark:text-white/80 bg-white dark:bg-gray-900 border border-gray-300 dark:border-blue-900/40 transition-colors duration-200 appearance-none rounded-lg',
                        {
                            'hover:border-blue-500 focus:outline-none focus:outline-offset-0 focus:shadow-[0_0_0_0.2rem_rgba(191,219,254,1)] dark:focus:shadow-[0_0_0_0.2rem_rgba(147,197,253,0.5)]': !context.disabled,
                            'opacity-60 select-none pointer-events-none cursor-default': context.disabled
                        },
                        {
                            'text-lg px-4 py-4': props.size == 'large',
                            'text-xs px-2 py-2': props.size == 'small',
                            'p-3 text-base': props.size == null
                        }
                    ]
                })
            },
            panel: {
                header: ({ props: PanelProps }) => ({
                    class: [
                        'flex items-center justify-between', // flex and alignments
                        'border border-gray-300 bg-gray-100 text-gray-700 rounded-tl-lg rounded-tr-lg', // borders and colors
                        'dark:bg-gray-900 dark:border-blue-900/40 dark:text-white/80', // Dark mode
                        { 'p-5': !props.toggleable, 'py-3 px-5': props.toggleable } // condition
                    ]
                }),
                title: {
                    class: ['leading-none font-bold']
                },
                toggler: {
                    class: [
                        'inline-flex items-center justify-center overflow-hidden relative no-underline', // alignments
                        'w-8 h-8 text-gray-600 border-0 bg-transparent rounded-full transition duration-200 ease-in-out', // widths, borders, and transitions
                        'hover:text-gray-900 hover:border-transparent hover:bg-gray-200 dark:hover:text-white/80 dark:hover:bg-gray-800/80 dark:focus:shadow-[inset_0_0_0_0.2rem_rgba(147,197,253,0.5)]', // hover
                        'focus:outline-none focus:outline-offset-0 focus:shadow-[0_0_0_0.2rem_rgba(191,219,254,1)]' // focus
                    ]
                },
                togglerIcon: {
                    class: ['inline-block']
                },
                content: {
                    class: [
                        'p-5 border border-gray-300 bg-white text-gray-700 border-t-0 last:rounded-br-lg last:rounded-bl-lg',
                        'dark:bg-gray-900 dark:border-blue-900/40 dark:text-white/80' // Dark mode
                    ] // padding, borders, and colors
                }
            },
            organizationchart: {
                table: 'mx-auto my-0 border-spacing-0 border-separate',
                cell: 'text-center text-xs align-top py-0 px-3',
                node: {
                    class: [
                        'relative inline-block bg-white border border-gray-300 text-gray-600 p-5',
                        'dark:border-blue-900/40 dark:bg-gray-900 dark:text-white/80' // Dark Mode
                    ]
                },
                linecell: 'text-center align-top py-0 px-3',
                linedown: {
                    class: [
                        'mx-auto my-0 w-px h-[20px] bg-gray-300',
                        'dark:bg-blue-900/40' //Dark Mode
                    ]
                },
                lineleft: ({ context }) => ({
                    class: [
                        'text-center align-top py-0 px-3 rounded-none border-r border-gray-300',
                        'dark:border-blue-900/40', //Dark Mode
                        {
                            'border-t': context.lineTop
                        }
                    ]
                }),
                lineright: ({ context }) => ({
                    class: [
                        'text-center align-top py-0 px-3 rounded-none',
                        'dark:border-blue-900/40', //Dark Mode
                        {
                            'border-t border-gray-300': context.lineTop
                        }
                    ]
                }),
                nodecell: 'text-center align-top py-0 px-3',
                nodetoggler: {
                    class: [
                        'absolute bottom-[-0.75rem] left-2/4 -ml-3 w-6 h-6 bg-inherit text-inherit rounded-full z-2 cursor-pointer no-underline select-none',
                        'focus:outline-none focus:outline-offset-0 focus:shadow-[0_0_0_0.2rem_rgba(191,219,254,1)] dark:focus:shadow-[0_0_0_0.2rem_rgba(147,197,253,0.5)]' // Focus styles
                    ]
                },
                nodetogglericon: 'relative inline-block w-4 h-4'
            }
        }

        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(PrimeVue,{unstyled:true, pt:MyDesignSystem})
            .use(VueApexCharts)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
