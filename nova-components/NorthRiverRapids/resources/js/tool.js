Nova.booting((Vue, router) => {
    router.addRoutes([
        {
            name: 'NorthRiverRapids',
            path: '/NorthRiverRapids',
            component: require('./components/Tool'),
        },
    ])
});
