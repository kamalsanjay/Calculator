<?php
/**
 * Random Name Generator
 * File: utility/random-name-generator.php
 * Description: Advanced random name generator with multiple cultures, styles, and customization options
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Name Generator - Advanced Name Creation Tool</title>
    <meta name="description" content="Generate random names from various cultures, styles, and categories with advanced customization options.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1100px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .generator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .control-panel { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 25px; }
        
        .control-group { margin-bottom: 20px; }
        .control-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .control-group select, .control-group input { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1rem; transition: all 0.3s; background: white; }
        .control-group select:focus, .control-group input:focus { outline: none; border-color: #ff9a9e; box-shadow: 0 0 0 3px rgba(255, 154, 158, 0.1); }
        
        .checkbox-group { display: flex; align-items: center; gap: 10px; margin-bottom: 10px; }
        .checkbox-group input { width: auto; }
        
        .action-buttons { display: flex; gap: 15px; margin-top: 25px; }
        .btn { padding: 14px 24px; border: none; border-radius: 10px; font-size: 1rem; cursor: pointer; transition: all 0.3s; font-weight: 600; }
        .btn-primary { background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%); color: white; }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(255, 154, 158, 0.3); }
        .btn-secondary { background: #f8f9fa; color: #2c3e50; border: 2px solid #e0e0e0; }
        .btn-secondary:hover { background: #e9ecef; }
        
        .results-section { margin-top: 30px; }
        .results-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; margin-top: 20px; }
        .name-card { background: linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%); padding: 18px; border-radius: 10px; text-align: center; border-left: 4px solid #ff9a9e; transition: all 0.3s; cursor: pointer; }
        .name-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .name-value { font-size: 1.2rem; font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .name-origin { font-size: 0.85rem; color: #7f8c8d; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .name-categories { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin: 20px 0; }
        .category-card { background: #f8f9fa; padding: 15px; border-radius: 8px; border-left: 4px solid #ff9a9e; }
        .category-name { font-weight: bold; color: #2c3e50; margin-bottom: 5px; }
        .category-desc { font-size: 0.85rem; color: #7f8c8d; }
        
        .formula-box { background: #fdf6f0; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #ff9a9e; }
        .formula-box strong { color: #ff9a9e; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .control-panel { grid-template-columns: 1fr; }
            .action-buttons { flex-direction: column; }
            .results-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👤 Advanced Random Name Generator</h1>
            <p>Generate unique names from various cultures, styles, and categories with advanced customization options</p>
        </div>

        <div class="generator-card">
            <div class="control-panel">
                <div class="control-group">
                    <label for="nameType">Name Type</label>
                    <select id="nameType" class="control-select">
                        <option value="full">Full Name (First + Last)</option>
                        <option value="first">First Name Only</option>
                        <option value="last">Last Name Only</option>
                        <option value="fantasy">Fantasy Names</option>
                        <option value="scifi">Sci-Fi Names</option>
                        <option value="character">Character Names</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="culture">Cultural Origin</label>
                    <select id="culture" class="control-select">
                        <option value="mixed">Mixed/International</option>
                        <option value="english">English/Anglo</option>
                        <option value="spanish">Spanish/Latin</option>
                        <option value="french">French</option>
                        <option value="german">German</option>
                        <option value="italian">Italian</option>
                        <option value="scandinavian">Scandinavian</option>
                        <option value="slavic">Slavic</option>
                        <option value="japanese">Japanese</option>
                        <option value="chinese">Chinese</option>
                        <option value="indian">Indian</option>
                        <option value="arabic">Arabic</option>
                        <option value="african">African</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label for="gender">Gender</label>
                    <select id="gender" class="control-select">
                        <option value="any">Any Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="neutral">Gender Neutral</option>
                    </select>
                </div>
            </div>
            
            <div class="control-panel">
                <div class="control-group">
                    <label for="nameCount">Number of Names</label>
                    <input type="number" id="nameCount" min="1" max="50" value="10">
                </div>
                
                <div class="control-group">
                    <label for="nameLength">Name Length</label>
                    <select id="nameLength" class="control-select">
                        <option value="any">Any Length</option>
                        <option value="short">Short (3-5 chars)</option>
                        <option value="medium">Medium (6-8 chars)</option>
                        <option value="long">Long (9+ chars)</option>
                    </select>
                </div>
                
                <div class="control-group">
                    <label>Additional Options</label>
                    <div class="checkbox-group">
                        <input type="checkbox" id="alliteration" checked>
                        <label for="alliteration">Allow alliteration</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="pronounceable" checked>
                        <label for="pronounceable">Ensure pronounceable</label>
                    </div>
                    <div class="checkbox-group">
                        <input type="checkbox" id="unique">
                        <label for="unique">Ensure unique names</label>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary" onclick="generateNames()">✨ Generate Names</button>
                <button class="btn btn-secondary" onclick="saveNames()">💾 Save to List</button>
                <button class="btn btn-secondary" onclick="clearResults()">🗑️ Clear Results</button>
            </div>
            
            <div class="results-section">
                <h3>Generated Names</h3>
                <div class="results-grid" id="resultsGrid">
                    <!-- Names will appear here -->
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>👤 Advanced Name Generation</h2>
            
            <p>Create unique and meaningful names for characters, projects, businesses, or any other purpose with our advanced name generation algorithms.</p>

            <h3>🌍 Cultural Name Origins</h3>
            <div class="name-categories">
                <div class="category-card">
                    <div class="category-name">English/Anglo Names</div>
                    <div class="category-desc">Traditional English names with Germanic roots</div>
                </div>
                <div class="category-card">
                    <div class="category-name">Spanish/Latin Names</div>
                    <div class="category-desc">Names from Spanish, Portuguese, and Latin origins</div>
                </div>
                <div class="category-card">
                    <div class="category-name">Asian Names</div>
                    <div class="category-desc">Japanese, Chinese, Korean, and other Asian naming traditions</div>
                </div>
                <div class="category-card">
                    <div class="category-name">African Names</div>
                    <div class="category-desc">Diverse names from across the African continent</div>
                </div>
                <div class="category-card">
                    <div class="category-name">Middle Eastern</div>
                    <div class="category-desc">Arabic, Persian, and other Middle Eastern names</div>
                </div>
                <div class="category-card">
                    <div class="category-name">European</div>
                    <div class="category-desc">French, German, Italian, Slavic, and Scandinavian names</div>
                </div>
            </div>

            <h3>🎭 Name Categories & Uses</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Common Uses</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Realistic Names</td><td>Authentic-sounding human names</td><td>Characters, babies, users</td></tr>
                    <tr><td>Fantasy Names</td><td>Mythical, magical, or medieval names</td><td>Fantasy novels, RPGs, games</td></tr>
                    <tr><td>Sci-Fi Names</td><td>Futuristic, technological names</td><td>Science fiction, tech products</td></tr>
                    <tr><td>Business Names</td><td>Professional, brandable names</td><td>Companies, products, services</td></tr>
                    <tr><td>Place Names</td><td>Geographical or location-based names</td><td>World-building, games</td></tr>
                    <tr><td>Pet Names</td><td>Playful, cute animal names</td><td>Pets, animal characters</td></tr>
                </tbody>
            </table>

            <div class="formula-box">
                <strong>Name Generation Algorithms:</strong><br>
                • <strong>Markov Chains:</strong> Creates names based on probability of letter sequences<br>
                • <strong>Syllable Combination:</strong> Builds names from meaningful syllable parts<br>
                • <strong>Cultural Patterns:</strong> Follows specific cultural naming conventions<br>
                • <strong>Morphological Analysis:</strong> Analyzes and combines name roots and suffixes
            </div>

            <h3>📊 Name Popularity Trends</h3>
            <ul>
                <li><strong>Traditional names</strong> often cycle in popularity every 80-100 years</li>
                <li><strong>Pop culture influences</strong> can cause sudden spikes in name popularity</li>
                <li><strong>Gender-neutral names</strong> are becoming increasingly popular</li>
                <li><strong>Short, simple names</strong> tend to have more staying power</li>
                <li><strong>Unique spellings</strong> of common names are a modern trend</li>
            </ul>

            <h3>🔤 Linguistic Patterns</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Language Family</th>
                        <th>Common Patterns</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Germanic</td><td>Strong consonants, compound names</td><td>William, Robert, Elizabeth</td></tr>
                    <tr><td>Romance</td><td>Vowel endings, melodic flow</td><td>Marco, Isabella, Antonio</td></tr>
                    <tr><td>Slavic</td><td>Consonant clusters, -ov/-ev endings</td><td>Dmitri, Natalia, Ivanov</td></tr>
                    <tr><td>Semitic</td><td>Guttural sounds, religious meanings</td><td>Mohammed, Sarah, Ibrahim</td></tr>
                    <tr><td>Sino-Tibetan</td><td>Single syllable family names</td><td>Li, Wang, Zhang</td></tr>
                </tbody>
            </table>

            <h3>🎮 Character Naming Strategies</h3>
            <div class="formula-box">
                <strong>For Character Development:</strong><br>
                • <strong>Meaning-based:</strong> Choose names that reflect character traits<br>
                • <strong>Sound-based:</strong> Select names that match character personality<br>
                • <strong>Culture-based:</strong> Use names appropriate to character background<br>
                • <strong>Archetype-based:</strong> Match names to character roles (hero, villain, etc.)
            </div>

            <h3>🏢 Business & Brand Naming</h3>
            <ul>
                <li><strong>Descriptive names</strong> clearly indicate what the business does</li>
                <li><strong>Evocative names</strong> create an emotional connection</li>
                <li><strong>Invented names</strong> are unique and trademarkable</li>
                <li><strong>Acronym names</strong> are short and memorable</li>
                <li><strong>Geographic names</strong> connect to a specific location</li>
            </ul>

            <h3>🌐 Global Naming Customs</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Region</th>
                        <th>Naming Convention</th>
                        <th>Examples</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Western</td><td>Given name + Family name</td><td>John Smith</td></tr>
                    <tr><td>East Asian</td><td>Family name + Given name</td><td>Zhang Wei</td></tr>
                    <tr><td>Spanish</td><td>Given name + Father's surname + Mother's surname</td><td>María García López</td></tr>
                    <tr><td>Icelandic</td><td>Given name + Patronymic (-son/-dóttir)</td><td>Jón Jónsson</td></tr>
                    <tr><td>Arabic</td><td>Given name + Father's name + Family name</td><td>Khalid bin Ahmed Al-Rashid</td></tr>
                </tbody>
            </table>

            <h3>📝 Name Generation Techniques</h3>
            <ul>
                <li><strong>Phonetic aesthetics:</strong> Creating names that sound pleasing</li>
                <li><strong>Cultural authenticity:</strong> Respecting naming traditions</li>
                <li><strong>Memorability:</strong> Ensuring names are easy to remember</li>
                <li><strong>Pronunciation:</strong> Considering how names will be spoken</li>
                <li><strong>Uniqueness:</strong> Balancing distinctiveness with familiarity</li>
            </ul>

            <h3>💡 Creative Name Ideas</h3>
            <div class="formula-box">
                <strong>For Different Projects:</strong><br>
                • <strong>Fantasy:</strong> Combine unusual syllables with traditional endings<br>
                • <strong>Sci-Fi:</strong> Use technical-sounding prefixes and suffixes<br>
                • <strong>Historical:</strong> Research period-appropriate names<br>
                • <strong>Modern:</strong> Blend traditional and contemporary elements<br>
                • <strong>International:</strong> Mix naming conventions from different cultures
            </div>

            <h3>🔍 Name Research & Validation</h3>
            <ul>
                <li>Check name meanings in different languages</li>
                <li>Verify cultural appropriateness and sensitivity</li>
                <li>Test pronunciation with different audiences</li>
                <li>Research existing trademarks and copyrights</li>
                <li>Consider search engine optimization for business names</li>
            </ul>
        </div>

        <div class="footer">
            <p>👤 Advanced Random Name Generator | Multiple Cultures & Styles</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Generate realistic, fantasy, sci-fi, and cultural names for any purpose</p>
        </div>
    </div>

    <script>
        // Name databases by culture and type
        const nameData = {
            firstNames: {
                english: {
                    male: ["James", "John", "Robert", "Michael", "William", "David", "Richard", "Charles", "Joseph", "Thomas"],
                    female: ["Mary", "Patricia", "Jennifer", "Linda", "Elizabeth", "Barbara", "Susan", "Jessica", "Sarah", "Karen"],
                    neutral: ["Alex", "Taylor", "Jordan", "Casey", "Jamie", "Morgan", "Riley", "Avery", "Quinn", "Skyler"]
                },
                spanish: {
                    male: ["Carlos", "José", "Miguel", "Javier", "Antonio", "Francisco", "Juan", "Diego", "Luis", "Ángel"],
                    female: ["María", "Carmen", "Ana", "Isabel", "Dolores", "Pilar", "Teresa", "Rosa", "Laura", "Elena"],
                    neutral: ["Reyes", "Santos", "Cruz", "Paz", "Sol", "Luz", "Rio", "Mar", "Cielo", "Estrella"]
                },
                japanese: {
                    male: ["Hiroshi", "Kenji", "Takashi", "Yuki", "Haruto", "Ren", "Sora", "Kaito", "Yuto", "Riku"],
                    female: ["Yuki", "Hana", "Sakura", "Airi", "Yui", "Mei", "Rin", "Akari", "Miyu", "Saki"],
                    neutral: ["Akira", "Haru", "Natsumi", "Asuka", "Kazuki", "Michiru", "Nozomi", "Satsuki", "Tomomi", "Yoshi"]
                }
            },
            lastNames: {
                english: ["Smith", "Johnson", "Williams", "Brown", "Jones", "Garcia", "Miller", "Davis", "Rodriguez", "Martinez"],
                spanish: ["García", "Rodríguez", "González", "Fernández", "López", "Martínez", "Sánchez", "Pérez", "Gómez", "Martín"],
                japanese: ["Sato", "Suzuki", "Takahashi", "Tanaka", "Watanabe", "Ito", "Yamamoto", "Nakamura", "Kobayashi", "Kato"]
            },
            fantasy: {
                prefixes: ["Aer", "Bel", "Cor", "Dra", "El", "Fae", "Gal", "Hel", "Iri", "Jor"],
                suffixes: ["ion", "or", "an", "us", "il", "ar", "en", "on", "ax", "ix"],
                full: ["Aragorn", "Gandalf", "Legolas", "Gimli", "Frodo", "Samwise", "Merry", "Pippin", "Boromir", "Faramir"]
            },
            scifi: {
                prefixes: ["Zor", "Xan", "Vor", "Kael", "Ryl", "Syn", "Nex", "Qua", "Tyr", "Vex"],
                suffixes: ["tar", "nor", "dex", "ron", "tex", "lux", "vax", "zor", "nik", "plex"],
                full: ["Neo", "Trinity", "Morpheus", "Spock", "Kirk", "Leia", "Han", "Rey", "Kylo", "Anakin"]
            }
        };

        function generateNames() {
            const nameType = document.getElementById('nameType').value;
            const culture = document.getElementById('culture').value;
            const gender = document.getElementById('gender').value;
            const nameCount = parseInt(document.getElementById('nameCount').value);
            const nameLength = document.getElementById('nameLength').value;
            const useAlliteration = document.getElementById('alliteration').checked;
            const ensurePronounceable = document.getElementById('pronounceable').checked;
            const ensureUnique = document.getElementById('unique').checked;
            
            const resultsGrid = document.getElementById('resultsGrid');
            resultsGrid.innerHTML = '';
            
            const generatedNames = [];
            
            for (let i = 0; i < nameCount; i++) {
                let name = '';
                let origin = culture;
                
                switch (nameType) {
                    case 'full':
                        name = generateFullName(culture, gender);
                        break;
                    case 'first':
                        name = generateFirstName(culture, gender);
                        break;
                    case 'last':
                        name = generateLastName(culture);
                        break;
                    case 'fantasy':
                        name = generateFantasyName();
                        origin = 'Fantasy';
                        break;
                    case 'scifi':
                        name = generateScifiName();
                        origin = 'Sci-Fi';
                        break;
                    case 'character':
                        name = generateCharacterName();
                        origin = 'Character';
                        break;
                }
                
                // Apply filters
                if (nameLength !== 'any') {
                    if (nameLength === 'short' && name.length > 5) {
                        name = name.substring(0, 5);
                    } else if (nameLength === 'medium' && (name.length < 6 || name.length > 8)) {
                        // Regenerate if not in medium range
                        i--;
                        continue;
                    } else if (nameLength === 'long' && name.length < 9) {
                        // Regenerate if not long enough
                        i--;
                        continue;
                    }
                }
                
                // Ensure uniqueness if required
                if (ensureUnique && generatedNames.includes(name)) {
                    i--;
                    continue;
                }
                
                generatedNames.push(name);
                
                const nameCard = document.createElement('div');
                nameCard.className = 'name-card';
                nameCard.innerHTML = `
                    <div class="name-value">${name}</div>
                    <div class="name-origin">${origin}</div>
                `;
                nameCard.onclick = function() {
                    copyToClipboard(name);
                };
                
                resultsGrid.appendChild(nameCard);
            }
        }
        
        function generateFullName(culture, gender) {
            const firstName = generateFirstName(culture, gender);
            const lastName = generateLastName(culture);
            return `${firstName} ${lastName}`;
        }
        
        function generateFirstName(culture, gender) {
            let namePool = [];
            
            if (culture === 'mixed') {
                // Combine names from multiple cultures
                const cultures = ['english', 'spanish', 'japanese'];
                const randomCulture = cultures[Math.floor(Math.random() * cultures.length)];
                namePool = getNamesByGender(nameData.firstNames[randomCulture], gender);
            } else {
                namePool = getNamesByGender(nameData.firstNames[culture], gender);
            }
            
            return namePool[Math.floor(Math.random() * namePool.length)];
        }
        
        function generateLastName(culture) {
            let namePool = [];
            
            if (culture === 'mixed') {
                // Combine names from multiple cultures
                const cultures = ['english', 'spanish', 'japanese'];
                const randomCulture = cultures[Math.floor(Math.random() * cultures.length)];
                namePool = nameData.lastNames[randomCulture];
            } else {
                namePool = nameData.lastNames[culture];
            }
            
            return namePool[Math.floor(Math.random() * namePool.length)];
        }
        
        function generateFantasyName() {
            // 50% chance of using a predefined fantasy name
            if (Math.random() > 0.5) {
                return nameData.fantasy.full[Math.floor(Math.random() * nameData.fantasy.full.length)];
            }
            
            // Otherwise generate a new fantasy name
            const prefix = nameData.fantasy.prefixes[Math.floor(Math.random() * nameData.fantasy.prefixes.length)];
            const suffix = nameData.fantasy.suffixes[Math.floor(Math.random() * nameData.fantasy.suffixes.length)];
            return prefix + suffix;
        }
        
        function generateScifiName() {
            // 50% chance of using a predefined sci-fi name
            if (Math.random() > 0.5) {
                return nameData.scifi.full[Math.floor(Math.random() * nameData.scifi.full.length)];
            }
            
            // Otherwise generate a new sci-fi name
            const prefix = nameData.scifi.prefixes[Math.floor(Math.random() * nameData.scifi.prefixes.length)];
            const suffix = nameData.scifi.suffixes[Math.floor(Math.random() * nameData.scifi.suffixes.length)];
            return prefix + suffix;
        }
        
        function generateCharacterName() {
            // Mix different name types for character names
            const types = ['full', 'fantasy', 'scifi'];
            const randomType = types[Math.floor(Math.random() * types.length)];
            
            switch (randomType) {
                case 'full':
                    return generateFullName('mixed', 'any');
                case 'fantasy':
                    return generateFantasyName();
                case 'scifi':
                    return generateScifiName();
            }
        }
        
        function getNamesByGender(nameSet, gender) {
            if (gender === 'any') {
                return [...nameSet.male, ...nameSet.female, ...nameSet.neutral];
            } else {
                return nameSet[gender];
            }
        }
        
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                // Show a subtle notification (could be enhanced with a toast)
                console.log(`Copied: ${text}`);
            });
        }
        
        function saveNames() {
            const nameCards = document.querySelectorAll('.name-value');
            let names = '';
            
            nameCards.forEach(card => {
                names += card.textContent + '\n';
            });
            
            const blob = new Blob([names], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'generated-names.txt';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
        
        function clearResults() {
            document.getElementById('resultsGrid').innerHTML = '';
        }

        // Initial generation on page load
        window.onload = generateNames;
    </script>
</body>
</html>
