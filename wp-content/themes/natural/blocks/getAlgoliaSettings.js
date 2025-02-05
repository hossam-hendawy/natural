const appId = '09XMSTXEX9';
const apiKey = '0fd37233918cb3c864cf80fc1129f5db';
const indexName = 'toc_strattic_dev';

const url = `https://${appId}-dsn.algolia.net/1/indexes/${indexName}/settings`;

const headers = {
  'X-Algolia-API-Key': apiKey,
  'X-Algolia-Application-Id': appId
};

fetch(url, { headers })
  .then(response => response.json())
  .then(settings => {
    console.log('Settings:', settings);

    // Here you can write the settings to a file or do something else with them
    // For example, saving to a local file is not possible directly in the browser due to security restrictions
  })
  .catch(error => console.error('Error:', error));
