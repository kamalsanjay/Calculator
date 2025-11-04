<?php
/**
 * Minecraft Calculator
 * File: gaming/minecraft-calculator.php
 * Description: Advanced Minecraft crafting, building, and gameplay calculators
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minecraft Calculator - Crafting, Building & Gameplay Tools</title>
    <meta name="description" content="Advanced Minecraft calculators for crafting recipes, building materials, mob spawning, redstone circuits, and gameplay mechanics.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%); min-height: 100vh; padding: 20px; }
        
        .container { max-width: 1200px; margin: 0 auto; }
        
        .header { background: rgba(255,255,255,0.95); padding: 30px; border-radius: 20px 20px 0 0; box-shadow: 0 -5px 20px rgba(0,0,0,0.1); }
        .header h1 { color: #2c3e50; font-size: 2rem; margin-bottom: 10px; display: flex; align-items: center; gap: 12px; }
        .header p { color: #7f8c8d; font-size: 1.05rem; line-height: 1.6; }
        
        .calculator-card { background: white; padding: 35px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
        
        .tab-container { margin-bottom: 25px; }
        .tab-buttons { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 20px; }
        .tab-btn { padding: 12px 20px; background: #f5f5f5; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s; font-weight: 600; color: #555; }
        .tab-btn.active { background: #4CAF50; color: white; }
        .tab-btn:hover:not(.active) { background: #e0e0e0; }
        
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        
        .calculator-row { display: grid; grid-template-columns: 1fr auto 1fr; gap: 20px; align-items: end; margin-bottom: 25px; }
        
        .input-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #34495e; font-size: 0.95rem; }
        .input-wrapper input, .input-wrapper select { width: 100%; padding: 14px 16px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 1.1rem; transition: all 0.3s; }
        .input-wrapper input:focus, .input-wrapper select:focus { outline: none; border-color: #4CAF50; box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1); }
        
        .swap-btn { background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%); color: white; border: none; border-radius: 50%; width: 50px; height: 50px; font-size: 1.3rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; }
        .swap-btn:hover { transform: rotate(180deg); }
        
        .result-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-top: 25px; }
        .result-card { background: linear-gradient(135deg, #E8F5E9 0%, #C8E6C9 100%); padding: 18px; border-radius: 10px; border-left: 4px solid #4CAF50; }
        .result-unit { color: #2E7D32; font-size: 0.85rem; margin-bottom: 5px; font-weight: 600; }
        .result-value { font-size: 1.15rem; font-weight: bold; color: #388E3C; word-wrap: break-word; }
        
        .quick-actions { background: #f8f9fa; padding: 25px; border-radius: 12px; margin-top: 25px; }
        .quick-actions h3 { color: #2c3e50; margin-bottom: 15px; font-size: 1.1rem; }
        .quick-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px; }
        .quick-btn { padding: 12px; background: white; border: 2px solid #e0e0e0; border-radius: 8px; cursor: pointer; transition: all 0.3s; text-align: center; }
        .quick-btn:hover { border-color: #4CAF50; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(76, 175, 80, 0.15); }
        .quick-value { font-weight: bold; color: #4CAF50; font-size: 1rem; }
        .quick-label { font-size: 0.8rem; color: #7f8c8d; margin-top: 4px; }
        
        .info-section { background: white; padding: 30px; }
        .info-section h2 { color: #2c3e50; margin-bottom: 15px; font-size: 1.4rem; }
        .info-section h3 { color: #34495e; margin: 20px 0 10px 0; font-size: 1.1rem; }
        .info-section p { color: #555; line-height: 1.8; margin-bottom: 15px; }
        .info-section ul { margin-left: 20px; margin-bottom: 15px; }
        .info-section li { color: #555; line-height: 1.8; margin-bottom: 8px; }
        
        .conversion-table { width: 100%; border-collapse: collapse; margin: 20px 0; font-size: 0.9rem; }
        .conversion-table th, .conversion-table td { padding: 12px; text-align: left; border-bottom: 1px solid #e0e0e0; }
        .conversion-table th { background: #f8f9fa; color: #2c3e50; font-weight: 600; }
        .conversion-table tr:hover { background: #E8F5E9; }
        
        .formula-box { background: #E8F5E9; padding: 20px; border-radius: 10px; margin: 20px 0; border-left: 4px solid #4CAF50; }
        .formula-box strong { color: #4CAF50; }
        
        .recipe-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin: 20px 0; }
        .recipe-card { border: 1px solid #e0e0e0; border-radius: 8px; padding: 15px; background: #f9f9f9; }
        .recipe-title { font-weight: bold; margin-bottom: 10px; color: #2E7D32; }
        .recipe-ingredients { font-size: 0.9rem; color: #555; }
        
        .footer { background: rgba(255,255,255,0.95); padding: 25px; border-radius: 0 0 20px 20px; text-align: center; color: #7f8c8d; }
        
        @media (max-width: 768px) {
            .calculator-row { grid-template-columns: 1fr; gap: 15px; }
            .swap-btn { margin: 10px auto; }
            .result-grid { grid-template-columns: 1fr; }
            .header h1 { font-size: 1.5rem; }
            .tab-buttons { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>⛏️ Minecraft Calculator</h1>
            <p>Advanced Minecraft calculators for crafting, building, mob spawning, redstone circuits, and gameplay mechanics</p>
        </div>

        <div class="calculator-card">
            <div class="tab-container">
                <div class="tab-buttons">
                    <button class="tab-btn active" data-tab="crafting">Crafting</button>
                    <button class="tab-btn" data-tab="building">Building</button>
                    <button class="tab-btn" data-tab="redstone">Redstone</button>
                    <button class="tab-btn" data-tab="mobs">Mob Spawning</button>
                    <button class="tab-btn" data-tab="enchanting">Enchanting</button>
                </div>

                <!-- Crafting Tab -->
                <div id="crafting" class="tab-content active">
                    <div class="calculator-row">
                        <div class="input-group">
                            <label for="craftItem">Item to Craft</label>
                            <div class="input-wrapper">
                                <select id="craftItem" class="unit-select">
                                    <option value="wood_planks">Wood Planks</option>
                                    <option value="sticks">Sticks</option>
                                    <option value="chest">Chest</option>
                                    <option value="furnace">Furnace</option>
                                    <option value="crafting_table">Crafting Table</option>
                                    <option value="torch">Torch</option>
                                    <option value="pickaxe">Pickaxe</option>
                                    <option value="sword">Sword</option>
                                    <option value="armor">Armor Set</option>
                                </select>
                            </div>
                        </div>

                        <button class="swap-btn" onclick="calculateCrafting()" title="Calculate">=</button>

                        <div class="input-group">
                            <label for="craftQuantity">Quantity Needed</label>
                            <div class="input-wrapper">
                                <input type="number" id="craftQuantity" placeholder="Enter quantity" min="1" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="result-grid" id="craftingResults"></div>

                    <div class="quick-actions">
                        <h3>⚡ Quick Crafting</h3>
                        <div class="quick-grid">
                            <div class="quick-btn" onclick="setCraftQuantity(1)">
                                <div class="quick-value">1</div>
                                <div class="quick-label">Item</div>
                            </div>
                            <div class="quick-btn" onclick="setCraftQuantity(10)">
                                <div class="quick-value">10</div>
                                <div class="quick-label">Items</div>
                            </div>
                            <div class="quick-btn" onclick="setCraftQuantity(64)">
                                <div class="quick-value">64</div>
                                <div class="quick-label">Stack</div>
                            </div>
                            <div class="quick-btn" onclick="setCraftQuantity(128)">
                                <div class="quick-value">128</div>
                                <div class="quick-label">2 Stacks</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Building Tab -->
                <div id="building" class="tab-content">
                    <div class="calculator-row">
                        <div class="input-group">
                            <label for="buildBlock">Block Type</label>
                            <div class="input-wrapper">
                                <select id="buildBlock" class="unit-select">
                                    <option value="stone">Stone</option>
                                    <option value="wood_planks">Wood Planks</option>
                                    <option value="bricks">Bricks</option>
                                    <option value="cobblestone">Cobblestone</option>
                                    <option value="sandstone">Sandstone</option>
                                    <option value="nether_bricks">Nether Bricks</option>
                                    <option value="quartz">Quartz</option>
                                </select>
                            </div>
                        </div>

                        <button class="swap-btn" onclick="calculateBuilding()" title="Calculate">=</button>

                        <div class="input-group">
                            <label for="buildDimensions">Dimensions (L×W×H)</label>
                            <div class="input-wrapper">
                                <input type="text" id="buildDimensions" placeholder="10×10×5" value="10×10×5">
                            </div>
                        </div>
                    </div>

                    <div class="result-grid" id="buildingResults"></div>
                </div>

                <!-- Redstone Tab -->
                <div id="redstone" class="tab-content">
                    <div class="calculator-row">
                        <div class="input-group">
                            <label for="redstoneComponent">Component</label>
                            <div class="input-wrapper">
                                <select id="redstoneComponent" class="unit-select">
                                    <option value="repeater">Redstone Repeater</option>
                                    <option value="comparator">Redstone Comparator</option>
                                    <option value="torch">Redstone Torch</option>
                                    <option value="dust">Redstone Dust</option>
                                    <option value="block">Redstone Block</option>
                                    <option value="lamp">Redstone Lamp</option>
                                    <option value="piston">Piston</option>
                                    <option value="observer">Observer</option>
                                </select>
                            </div>
                        </div>

                        <button class="swap-btn" onclick="calculateRedstone()" title="Calculate">=</button>

                        <div class="input-group">
                            <label for="redstoneQuantity">Quantity Needed</label>
                            <div class="input-wrapper">
                                <input type="number" id="redstoneQuantity" placeholder="Enter quantity" min="1" value="1">
                            </div>
                        </div>
                    </div>

                    <div class="result-grid" id="redstoneResults"></div>
                </div>

                <!-- Mob Spawning Tab -->
                <div id="mobs" class="tab-content">
                    <div class="calculator-row">
                        <div class="input-group">
                            <label for="mobType">Mob Type</label>
                            <div class="input-wrapper">
                                <select id="mobType" class="unit-select">
                                    <option value="zombie">Zombie</option>
                                    <option value="skeleton">Skeleton</option>
                                    <option value="creeper">Creeper</option>
                                    <option value="spider">Spider</option>
                                    <option value="enderman">Enderman</option>
                                    <option value="witch">Witch</option>
                                    <option value="slime">Slime</option>
                                </select>
                            </div>
                        </div>

                        <button class="swap-btn" onclick="calculateMobSpawning()" title="Calculate">=</button>

                        <div class="input-group">
                            <label for="farmSize">Farm Size (blocks)</label>
                            <div class="input-wrapper">
                                <input type="number" id="farmSize" placeholder="Farm area" min="1" value="100">
                            </div>
                        </div>
                    </div>

                    <div class="result-grid" id="mobResults"></div>
                </div>

                <!-- Enchanting Tab -->
                <div id="enchanting" class="tab-content">
                    <div class="calculator-row">
                        <div class="input-group">
                            <label for="enchantItem">Item to Enchant</label>
                            <div class="input-wrapper">
                                <select id="enchantItem" class="unit-select">
                                    <option value="sword">Sword</option>
                                    <option value="pickaxe">Pickaxe</option>
                                    <option value="axe">Axe</option>
                                    <option value="shovel">Shovel</option>
                                    <option value="bow">Bow</option>
                                    <option value="armor">Armor</option>
                                    <option value="fishing_rod">Fishing Rod</option>
                                </select>
                            </div>
                        </div>

                        <button class="swap-btn" onclick="calculateEnchanting()" title="Calculate">=</button>

                        <div class="input-group">
                            <label for="enchantLevel">Target Level</label>
                            <div class="input-wrapper">
                                <input type="number" id="enchantLevel" placeholder="Enchantment level" min="1" max="30" value="15">
                            </div>
                        </div>
                    </div>

                    <div class="result-grid" id="enchantingResults"></div>
                </div>
            </div>
        </div>

        <div class="info-section">
            <h2>⛏️ Minecraft Calculators Guide</h2>
            
            <p>Comprehensive Minecraft calculators for all your crafting, building, and gameplay needs.</p>

            <h3>🛠️ Crafting Calculator</h3>
            <p>Calculate exactly how many resources you need to craft any item in Minecraft.</p>
            
            <div class="recipe-grid">
                <div class="recipe-card">
                    <div class="recipe-title">Wood Planks</div>
                    <div class="recipe-ingredients">1 Log = 4 Planks</div>
                </div>
                <div class="recipe-card">
                    <div class="recipe-title">Sticks</div>
                    <div class="recipe-ingredients">2 Planks = 4 Sticks</div>
                </div>
                <div class="recipe-card">
                    <div class="recipe-title">Chest</div>
                    <div class="recipe-ingredients">8 Planks = 1 Chest</div>
                </div>
                <div class="recipe-card">
                    <div class="recipe-title">Furnace</div>
                    <div class="recipe-ingredients">8 Cobblestone = 1 Furnace</div>
                </div>
            </div>

            <h3>🏗️ Building Calculator</h3>
            <p>Calculate blocks needed for structures of any size and shape.</p>
            
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Structure Type</th>
                        <th>Blocks Required</th>
                        <th>Common Materials</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Small House (10×10×5)</td><td>600 blocks</td><td>Wood, Stone, Cobblestone</td></tr>
                    <tr><td>Medium Castle</td><td>5,000-10,000 blocks</td><td>Stone Bricks, Cobblestone</td></tr>
                    <tr><td>Large Pyramid</td><td>50,000+ blocks</td><td>Sandstone, Stone</td></tr>
                    <tr><td>Nether Portal</td><td>14 obsidian</td><td>Obsidian</td></tr>
                    <tr><td>Beacon Pyramid</td><td>9-164 blocks</td><td>Iron, Gold, Diamond, Emerald</td></tr>
                </tbody>
            </table>

            <h3>🔴 Redstone Calculator</h3>
            <p>Plan complex redstone contraptions with precise component calculations.</p>
            
            <div class="formula-box">
                <strong>Redstone Component Recipes:</strong><br>
                • Redstone Repeater: 3 Stone + 2 Redstone Torches + 1 Redstone<br>
                • Redstone Comparator: 3 Stone + 3 Quartz + 1 Redstone Torch<br>
                • Redstone Torch: 1 Stick + 1 Redstone<br>
                • Piston: 3 Wood Planks + 4 Cobblestone + 1 Iron + 1 Redstone<br>
                • Observer: 6 Cobblestone + 2 Redstone + 1 Quartz
            </div>

            <h3>👹 Mob Spawning Calculator</h3>
            <p>Optimize your mob farms with precise spawning calculations.</p>
            
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Mob Type</th>
                        <th>Spawn Conditions</th>
                        <th>Drops</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Zombie</td><td>Light level 0-7</td><td>Rotten Flesh, Iron, Carrot, Potato</td></tr>
                    <tr><td>Skeleton</td><td>Light level 0-7</td><td>Bones, Arrows, Bows</td></tr>
                    <tr><td>Creeper</td><td>Light level 0-7</td><td>Gunpowder</td></tr>
                    <tr><td>Spider</td><td>Light level 0-7</td><td>String, Spider Eyes</td></tr>
                    <tr><td>Enderman</td><td>Light level 0-7</td><td>Ender Pearls</td></tr>
                </tbody>
            </table>

            <h3>✨ Enchanting Calculator</h3>
            <p>Calculate experience and lapis lazuli requirements for enchanting.</p>
            
            <div class="formula-box">
                <strong>Enchanting Costs:</strong><br>
                • Level 1-15: 1-15 experience levels + 1-3 lapis<br>
                • Level 16-30: 16-30 experience levels + 1-3 lapis<br>
                • Maximum enchantment: Level 30 + 3 lapis<br>
                • Bookshelf requirement: 15 bookshelves for level 30
            </div>

            <h3>📊 Minecraft Block Statistics</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Block Type</th>
                        <th>Blast Resistance</th>
                        <th>Hardness</th>
                        <th>Tool Required</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Stone</td><td>6</td><td>1.5</td><td>Pickaxe</td></tr>
                    <tr><td>Wood Planks</td><td>3</td><td>2</td><td>Axe</td></tr>
                    <tr><td>Iron Block</td><td>6</td><td>5</td><td>Pickaxe</td></tr>
                    <tr><td>Obsidian</td><td>1200</td><td>50</td><td>Diamond Pickaxe</td></tr>
                    <tr><td>Bedrock</td><td>18,000,000</td><td>-1</td><td>Unbreakable</td></tr>
                </tbody>
            </table>

            <h3>⚔️ Combat & Tools</h3>
            <ul>
                <li><strong>Diamond Sword:</strong> 7 attack damage, 1561 durability</li>
                <li><strong>Iron Pickaxe:</strong> 4 attack damage, 251 durability</li>
                <li><strong>Bow (fully charged):</strong> 6-10 damage depending on charge</li>
                <li><strong>Diamond Armor:</strong> 20 armor points (10 hearts protection)</li>
                <li><strong>Shield:</strong> Blocks 100% of melee damage when active</li>
            </ul>

            <h3>🌍 World Generation</h3>
            <div class="formula-box">
                <strong>Minecraft World Facts:</strong><br>
                • World height: -64 to 320 (384 blocks total)<br>
                • Maximum build height: 319<br>
                • Maximum coordinates: ±30,000,000<br>
                • Chunk size: 16×16×384 blocks<br>
                • Region file: 32×32 chunks (1024 chunks total)<br>
                • Strongholds: 128 per world
            </div>

            <h3>⏰ Game Mechanics</h3>
            <table class="conversion-table">
                <thead>
                    <tr>
                        <th>Game Element</th>
                        <th>Time/Duration</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>Day/Night Cycle</td><td>20 minutes</td><td>10 min day, 1.5 min sunset, 7 min night, 1.5 min sunrise</td></tr>
                    <tr><td>Item Despawn</td><td>5 minutes</td><td>300 game ticks</td></tr>
                    <tr><td>Crop Growth</td><td>Random ticks</td><td>Average 30 minutes for full growth</td></tr>
                    <tr><td>Furnace Smelting</td><td>10 seconds</td><td>1 item per 10 seconds</td></tr>
                    <tr><td>Composter</td><td>Random ticks</td><td>Average 20-30 items to fill</td></tr>
                </tbody>
            </table>

            <h3>💰 Villager Trading</h3>
            <ul>
                <li><strong>Librarian:</strong> Trades enchanted books, bookshelves, glass</li>
                <li><strong>Armorer:</strong> Trades armor, bells, chainmail armor</li>
                <li><strong>Weaponsmith:</strong> Trades weapons, tools, bell</li>
                <li><strong>Toolsmith:</strong> Trades tools, bell, enchanted tools</li>
                <li><strong>Butcher:</strong> Trades meat, sweet berries, rabbit stew</li>
                <li><strong>Cartographer:</strong> Trades maps, banners, compasses</li>
            </ul>

            <h3>🎯 Pro Tips</h3>
            <div class="formula-box">
                <strong>Efficient Minecraft Strategies:</strong><br>
                • Always use Fortune III on diamond/emerald ore<br>
                • Build mob farms at Y=30 for maximum rates<br>
                • Use water streams to transport items in farms<br>
                • Place torches every 6 blocks to prevent mob spawning<br>
                • Build iron farms in chunks that are always loaded<br>
                • Use villagers for renewable resources
            </div>
        </div>

        <div class="footer">
            <p>⛏️ Minecraft Calculator | Crafting, Building & Gameplay Tools</p>
            <p style="margin-top: 10px; font-size: 0.9rem;">Calculate resources for any Minecraft project - from simple tools to massive builds</p>
        </div>
    </div>

    <script>
        // Tab switching functionality
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                // Remove active class from all buttons and content
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
                
                // Add active class to clicked button and corresponding content
                button.classList.add('active');
                document.getElementById(button.dataset.tab).classList.add('active');
            });
        });

        // Crafting recipes data
        const craftingRecipes = {
            wood_planks: { log: 0.25, output: 4 },
            sticks: { planks: 0.5, output: 4 },
            chest: { planks: 8, output: 1 },
            furnace: { cobblestone: 8, output: 1 },
            crafting_table: { planks: 4, output: 1 },
            torch: { stick: 1, coal: 1, output: 4 },
            pickaxe: { planks: 3, sticks: 2, cobblestone: 3, output: 1 },
            sword: { planks: 2, sticks: 1, cobblestone: 2, output: 1 },
            armor: { planks: 24, leather: 24, iron: 24, diamond: 24, output: 4 }
        };

        // Building materials data
        const buildingMaterials = {
            stone: { name: "Stone", stack: 64 },
            wood_planks: { name: "Wood Planks", stack: 64 },
            bricks: { name: "Bricks", stack: 64 },
            cobblestone: { name: "Cobblestone", stack: 64 },
            sandstone: { name: "Sandstone", stack: 64 },
            nether_bricks: { name: "Nether Bricks", stack: 64 },
            quartz: { name: "Quartz Block", stack: 64 }
        };

        // Redstone components data
        const redstoneComponents = {
            repeater: { stone: 3, redstone_torch: 2, redstone: 1, output: 1 },
            comparator: { stone: 3, quartz: 3, redstone_torch: 1, output: 1 },
            torch: { stick: 1, redstone: 1, output: 1 },
            dust: { redstone: 1, output: 1 },
            block: { redstone: 9, output: 1 },
            lamp: { redstone: 4, glowstone: 1, output: 1 },
            piston: { planks: 3, cobblestone: 4, iron: 1, redstone: 1, output: 1 },
            observer: { cobblestone: 6, redstone: 2, quartz: 1, output: 1 }
        };

        // Mob spawning data
        const mobSpawning = {
            zombie: { spawn_chance: 0.1, drops: ["rotten_flesh", "iron", "carrot", "potato"] },
            skeleton: { spawn_chance: 0.1, drops: ["bone", "arrow", "bow"] },
            creeper: { spawn_chance: 0.1, drops: ["gunpowder"] },
            spider: { spawn_chance: 0.1, drops: ["string", "spider_eye"] },
            enderman: { spawn_chance: 0.05, drops: ["ender_pearl"] },
            witch: { spawn_chance: 0.05, drops: ["glowstone", "redstone", "sugar", "glass_bottle"] },
            slime: { spawn_chance: 0.1, drops: ["slime_ball"] }
        };

        // Enchanting data
        const enchantingCosts = {
            sword: { base_xp: 1, lapis: 1, max_level: 30 },
            pickaxe: { base_xp: 1, lapis: 1, max_level: 30 },
            axe: { base_xp: 1, lapis: 1, max_level: 30 },
            shovel: { base_xp: 1, lapis: 1, max_level: 30 },
            bow: { base_xp: 1, lapis: 1, max_level: 30 },
            armor: { base_xp: 1, lapis: 1, max_level: 30 },
            fishing_rod: { base_xp: 1, lapis: 1, max_level: 30 }
        };

        function calculateCrafting() {
            const item = document.getElementById('craftItem').value;
            const quantity = parseInt(document.getElementById('craftQuantity').value);
            const recipe = craftingRecipes[item];
            
            const results = document.getElementById('craftingResults');
            results.innerHTML = '';
            
            if (!recipe) return;
            
            // Calculate materials needed
            const batches = Math.ceil(quantity / recipe.output);
            
            for (const [material, amount] of Object.entries(recipe)) {
                if (material === 'output') continue;
                
                const totalNeeded = amount * batches;
                const stacks = Math.ceil(totalNeeded / 64);
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${formatMaterialName(material)}</div>
                    <div class="result-value">${totalNeeded} (${stacks} stacks)</div>
                `;
                results.appendChild(card);
            }
            
            // Add output card
            const outputCard = document.createElement('div');
            outputCard.className = 'result-card';
            outputCard.innerHTML = `
                <div class="result-unit">Crafting Output</div>
                <div class="result-value">${quantity} ${formatItemName(item)}</div>
            `;
            results.appendChild(outputCard);
        }

        function calculateBuilding() {
            const blockType = document.getElementById('buildBlock').value;
            const dimensions = document.getElementById('buildDimensions').value;
            const material = buildingMaterials[blockType];
            
            const results = document.getElementById('buildingResults');
            results.innerHTML = '';
            
            if (!material || !dimensions) return;
            
            // Parse dimensions (format: L×W×H)
            const dims = dimensions.split('×').map(d => parseInt(d.trim()));
            if (dims.length !== 3 || dims.some(isNaN)) return;
            
            const [length, width, height] = dims;
            const totalBlocks = length * width * height;
            const stacks = Math.ceil(totalBlocks / material.stack);
            const shulkerBoxes = Math.ceil(stacks / 27);
            
            const cards = [
                { unit: 'Total Blocks', value: totalBlocks.toLocaleString() },
                { unit: 'Stacks Needed', value: stacks },
                { unit: 'Shulker Boxes', value: shulkerBoxes },
                { unit: 'Material', value: material.name }
            ];
            
            cards.forEach(cardData => {
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${cardData.unit}</div>
                    <div class="result-value">${cardData.value}</div>
                `;
                results.appendChild(card);
            });
        }

        function calculateRedstone() {
            const component = document.getElementById('redstoneComponent').value;
            const quantity = parseInt(document.getElementById('redstoneQuantity').value);
            const recipe = redstoneComponents[component];
            
            const results = document.getElementById('redstoneResults');
            results.innerHTML = '';
            
            if (!recipe) return;
            
            // Calculate materials needed
            const batches = Math.ceil(quantity / recipe.output);
            
            for (const [material, amount] of Object.entries(recipe)) {
                if (material === 'output') continue;
                
                const totalNeeded = amount * batches;
                const stacks = Math.ceil(totalNeeded / 64);
                
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${formatMaterialName(material)}</div>
                    <div class="result-value">${totalNeeded} (${stacks} stacks)</div>
                `;
                results.appendChild(card);
            }
        }

        function calculateMobSpawning() {
            const mobType = document.getElementById('mobType').value;
            const farmSize = parseInt(document.getElementById('farmSize').value);
            const mobData = mobSpawning[mobType];
            
            const results = document.getElementById('mobResults');
            results.innerHTML = '';
            
            if (!mobData) return;
            
            // Calculate spawning rates
            const spawnsPerHour = Math.floor(farmSize * mobData.spawn_chance * 60);
            const dropsPerHour = spawnsPerHour; // Simplified calculation
            
            const cards = [
                { unit: 'Spawns Per Hour', value: spawnsPerHour },
                { unit: 'Drops Per Hour', value: dropsPerHour },
                { unit: 'Spawn Chance', value: `${(mobData.spawn_chance * 100).toFixed(1)}%` },
                { unit: 'Possible Drops', value: mobData.drops.join(', ') }
            ];
            
            cards.forEach(cardData => {
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${cardData.unit}</div>
                    <div class="result-value">${cardData.value}</div>
                `;
                results.appendChild(card);
            });
        }

        function calculateEnchanting() {
            const item = document.getElementById('enchantItem').value;
            const level = parseInt(document.getElementById('enchantLevel').value);
            const enchantData = enchantingCosts[item];
            
            const results = document.getElementById('enchantingResults');
            results.innerHTML = '';
            
            if (!enchantData || level < 1 || level > 30) return;
            
            // Calculate enchanting costs
            const xpCost = level;
            const lapisCost = Math.min(3, Math.ceil(level / 10));
            const bookshelves = level >= 30 ? 15 : Math.max(1, Math.floor(level / 2));
            
            const cards = [
                { unit: 'XP Levels', value: xpCost },
                { unit: 'Lapis Lazuli', value: lapisCost },
                { unit: 'Bookshelves', value: bookshelves },
                { unit: 'Max Possible Level', value: enchantData.max_level }
            ];
            
            cards.forEach(cardData => {
                const card = document.createElement('div');
                card.className = 'result-card';
                card.innerHTML = `
                    <div class="result-unit">${cardData.unit}</div>
                    <div class="result-value">${cardData.value}</div>
                `;
                results.appendChild(card);
            });
        }

        function formatMaterialName(material) {
            return material.split('_').map(word => 
                word.charAt(0).toUpperCase() + word.slice(1)
            ).join(' ');
        }

        function formatItemName(item) {
            return formatMaterialName(item);
        }

        function setCraftQuantity(quantity) {
            document.getElementById('craftQuantity').value = quantity;
            calculateCrafting();
        }

        // Auto-calculate on input
        document.getElementById('craftQuantity').addEventListener('input', calculateCrafting);
        document.getElementById('craftItem').addEventListener('change', calculateCrafting);
        document.getElementById('buildBlock').addEventListener('change', calculateBuilding);
        document.getElementById('buildDimensions').addEventListener('input', calculateBuilding);
        document.getElementById('redstoneComponent').addEventListener('change', calculateRedstone);
        document.getElementById('redstoneQuantity').addEventListener('input', calculateRedstone);
        document.getElementById('mobType').addEventListener('change', calculateMobSpawning);
        document.getElementById('farmSize').addEventListener('input', calculateMobSpawning);
        document.getElementById('enchantItem').addEventListener('change', calculateEnchanting);
        document.getElementById('enchantLevel').addEventListener('input', calculateEnchanting);

        // Initial calculations
        calculateCrafting();
        calculateBuilding();
        calculateRedstone();
        calculateMobSpawning();
        calculateEnchanting();
    </script>
</body>
</html>
