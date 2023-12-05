import Keycloak from 'keycloak-js';

const keycloak = new Keycloak({
  realm: process.env.KEYCLOAK_REALM,
  url: process.env.KEYCLOAK_URL,
  clientId: process.env.KEYCLOAK_CLIENT,
});

keycloak.init({ onLoad: 'login-required' }).then((authenticated) => {
  if (authenticated) {
    keycloak.loadUserInfo().then((userInfo) => {
      console.log('userInfo', userInfo)
      keycloak.roles = userInfo.roles || [];
    });
  } else {
    console.error('Autenticação falhou.');
  }
}).catch(() => {
  console.error('Configuração do Keycloak falhou.');
});

export { keycloak }

