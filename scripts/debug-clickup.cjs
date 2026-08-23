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
        console.log(`[DEBUG] Response: ${data.substring(0, 500)}`);
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
  // First get the folder ID from the space
  const folderId = '901213120323'; // From previous run
  
  console.log('Testing list creation...');
  console.log(`Folder ID: ${folderId}`);
  
  const result = await apiCall('POST', `/folder/${folderId}/list`, {
    name: 'Test List',
    status: [
      { status: 'to do', color: '#999990', orderindex: 0, type: 'open' }
    ]
  });
  
  console.log('\n[RESULT]:', JSON.stringify(result, null, 2));
}

testListCreation().catch(console.error);
