const https = require('https');

const API_TOKEN = 'pk_278415587_ASYVE7LAJVJY61Q0XQ0577KMLTG40J1N';
const TEAM_ID = '90121458327';

function apiCall(method, path, body = null) {
  return new Promise((resolve, reject) => {
    const options = {
      hostname: 'api.clickup.com',
      path: `/api/v2${path}`,
      method: method,
      headers: {
        'Authorization': API_TOKEN,
        'Content-Type': 'application/json'
      }
    };

    const req = https.request(options, (res) => {
      let data = '';
      res.on('data', (chunk) => data += chunk);
      res.on('end', () => {
        console.log(`\n[DEBUG] Status: ${res.statusCode}`);
        console.log(`[DEBUG] Response: ${data.substring(0, 1000)}`);
        try {
          resolve(JSON.parse(data));
        } catch (e) {
          reject(new Error(`Parse error: ${data}`));
        }
      });
    });

    req.on('error', reject);
    if (body) req.write(JSON.stringify(body));
    req.end();
  });
}

async function testListCreation() {
  // First, let's get the space to find the folder
  console.log('Getting space info...');
  const space = await apiCall('GET', `/space/90128864840`);
  
  console.log('\n[SPACE INFO]:', JSON.stringify(space, null, 2));
  
  // Try creating a list without status
  console.log('\n\nTrying to create list without status...');
  const result = await apiCall('POST', `/folder/901213120323/list`, {
    name: 'Test List Simple'
  });
  
  console.log('\n[RESULT]:', JSON.stringify(result, null, 2));
}

testListCreation().catch(console.error);
