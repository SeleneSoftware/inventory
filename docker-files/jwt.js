const jwt = require('jsonwebtoken');

const token = jwt.sign(
  {
    mercure: {
      publish: ['*'], // or subscribe: ['*']
    },
  },
  'nQp2WGR2YxJRHqbwl6N0FX+0NOgcnTR5vavVcQ9+VNk=',
  { algorithm: 'HS256' }
);

console.log(token);

