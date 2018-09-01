Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'swim-team-roster',
            path: '/swim-team-roster',
            component: require('./components/Tool'),
        },
    ])
})
