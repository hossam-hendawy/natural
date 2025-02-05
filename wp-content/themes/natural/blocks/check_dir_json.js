const fs = require('fs');
const path = require('path');

const jsonFilePath = './blocks.json'; // Replace with your JSON file path
const directoryPath = './'; // Replace with your directory path

// Read and parse the JSON file
const jsonData = JSON.parse(fs.readFileSync(jsonFilePath, 'utf8'));

// Read the directory contents
const folders = fs.readdirSync(directoryPath).filter(file => fs.statSync(path.join(directoryPath, file)).isDirectory());

// Find folders not in JSON
const foldersNotInJson = folders.filter(folder => !jsonData.hasOwnProperty(folder));

// Find JSON keys not in folders
const jsonKeysNotInFolders = Object.keys(jsonData).filter(key => !folders.includes(key));

// Add missing folder keys to JSON
foldersNotInJson.forEach(key => {
  jsonData[key] = {
    title: "",
    category: "",
    status: false,
    _NEW: true // Adding the NEW property
  };
});

// Add missing folder keys to JSON
jsonKeysNotInFolders.forEach(key => {
  jsonData[key]._MISSING = true
  jsonData[key].status = false
});

// Output the results (or handle them as needed)
console.log('Folders not in JSON:', foldersNotInJson);
console.log('JSON keys not in folders:', jsonKeysNotInFolders);
// console.log('Updated JSON:', jsonData);

// Optionally, write the updated JSON back to a file
fs.writeFileSync(jsonFilePath, JSON.stringify(jsonData, null, 2)); // This formats the JSON for readability
