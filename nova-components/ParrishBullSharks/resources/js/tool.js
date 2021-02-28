Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'parrish-bull-sharks',
      path: '/parrish-bull-sharks',
      component: require('./components/Tool'),
    },
  ])
})
