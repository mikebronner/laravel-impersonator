Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'laravel-impersonator',
            path: '/laravel-impersonator',
            component: require('./components/Tool'),
        },
    ])
})
