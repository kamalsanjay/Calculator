<?php
/**
 * Circle Calculator
 * File: circle-calculator.php
 * Description: Complete circle calculator with all properties
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Circle Calculator - Area, Circumference, Arc, Sector</title>
    <meta name="description" content="Calculate circle area, circumference, diameter, radius, arc length, sector area, and segment area online.">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 12px; }
        header { background: rgba(255,255,255,0.1); color: white; padding: 20px 16px; text-align: center; border-radius: 12px; margin-bottom: 16px; backdrop-filter: blur(10px); }
        header h1 { font-size: 1.5rem; margin-bottom: 8px; font-weight: 700; }
        header p { font-size: 0.875rem; opacity: 0.9; }
        .container { max-width: 100%; margin: 0 auto; }
        .breadcrumb { margin-bottom: 16px; text-align: center; }
        .breadcrumb a { color: white; text-decoration: none; font-weight: 500; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 8px; display: inline-block; backdrop-filter: blur(10px); font-size: 0.875rem; transition: all 0.3s; }
        .calculator-body { background: white; padding: 16px; border-radius: 16px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); margin-bottom: 16px; }
        .settings-panel { background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%); padding: 16px; border-radius: 12px; margin-bottom: 16px; border: 2px solid #667eea; }
        .settings-panel h4 { color: #667eea; margin-bottom: 12px; font-size: 1rem; }
        .settings-row { display: grid; grid-template-columns: 1fr; gap: 12px; }
        .setting-group { background: white; padding: 12px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .setting-group label { display: block; font-weight: 600; color: #555; margin-bottom: 8px; font-size: 0.875rem; }
        .setting-group select { width: 100%; padding: 10px; border: 2px solid #e0e0e0; border-radius: 6px; outline: none; font-size: 1rem; }
        .calc-tabs { display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 8px; margin-bottom: 16px; }
        .tab-btn { padding: 12px 8px; background: #f0f0f0; border: none; border-radius: 8px; color: #333; cursor: pointer; transition: all 0.3s; font-weight: 600; text-align: center; font-size: 0.8rem; }
        .tab-btn.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.15); }
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .input-section { margin-bottom: 16px; }
        .input-section label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; font-size: 0.9rem; }
        .input-section input, .input-section select { width: 100%; padding: 12px; border: 2px solid #e0e0e0; border-radius: 8px; font-size: 1rem; outline: none; transition: all 0.3s; }
        .input-section input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1); }
        .btn { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; padding: 14px 24px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1.1rem; transition: all 0.3s; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
        .btn:active { transform: translateY(0); }
        .result-section { background: linear-gradient(135deg, #f0f7ff 0%, #fff0f7 100%); padding: 20px; border-radius: 12px; border-left: 5px solid #667eea; margin-top: 20px; display: none; }
        .result-section.show { display: block; animation: slideIn 0.3s; }
        @keyframes slideIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .result-section h3 { color: #667eea; margin-bottom: 16px; font-size: 1.3rem; }
        .result-box { background: white; padding: 16px; border-radius: 10px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); border-left: 4px solid #4CAF50; }
        .result-label { font-size: 0.8rem; color: #666; margin-bottom: 6px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
        .result-value { font-size: 1.4rem; color: #4CAF50; font-weight: bold; font-family: 'Courier New', monospace; word-break: break-word; line-height: 1.4; }
        .formula-box { background: #f9f9f9; padding: 14px; border-radius: 8px; border-left: 4px solid #667eea; margin: 14px 0; font-size: 0.85rem; line-height: 1.7; }
        .formula-box strong { color: #667eea; display: block; margin-bottom: 6px; }
        .info-box { background: white; padding: 20px; border-radius: 12px; line-height: 1.8; box-shadow: 0 8px 30px rgba(0,0,0,0.15); margin-top: 16px; }
        .info-box h3 { color: #667eea; margin-bottom: 14px; font-size: 1.2rem; }
        .info-box p { margin-bottom: 10px; color: #555; font-size: 0.85rem; }
        
        /* Responsive breakpoints */
        @media (min-width: 480px) { .calc-tabs { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 768px) { 
            body { padding: 24px; }
            .container { max-width: 720px; margin: 0 auto; }
            header h1 { font-size: 2rem; }
            .calculator-body { padding: 24px; }
            .settings-row { grid-template-columns: repeat(2, 1fr); }
            .calc-tabs { grid-template-columns: repeat(4, 1fr); }
        }
        @media (min-width: 1024px) { 
            .container { max-width: 960px; }
            .settings-row { grid-template-columns: repeat(3, 1fr); }
        }
        @media (min-width: 1280px) { .container { max-width: 1100px; } }
        @media (max-width: 479px) { 
            .tab-btn { font-size: 0.75rem; padding: 10px 6px; }
            .result-value { font-size: 1.2rem; }
        }
    </style>
</head>
<body>
    <header>
        <h1>⭕ Circle Calculator</h1>
        <p>Calculate all circle properties with formulas</p>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="../index.php">← Back to Calculators</a>
        </div>

        <div class="calculator-body">
            <div class="settings-panel">
                <h4>⚙️ Settings</h4>
                <div class="settings-row">
                    <div class="setting-group">
                        <label>Unit</label>
                        <select id="unit">
                            <option value="m">Meters (m)</option>
                            <option value="cm">Centimeters (cm)</option>
                            <option value="mm">Millimeters (mm)</option>
                            <option value="km">Kilometers (km)</option>
                            <option value="in">Inches (in)</option>
                            <option value="ft">Feet (ft)</option>
                            <option value="yd">Yards (yd)</option>
                        </select>
                    </div>
                    <div class="setting-group">
                        <label>Decimal Places</label>
                        <select id="decimals">
                            <option value="2">2 places</option>
                            <option value="4" selected>4 places</option>
                            <option value="6">6 places</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="calc-tabs">
                <button class="tab-btn active" onclick="switchTab(0)">Basic</button>
                <button class="tab-btn" onclick="switchTab(1)">Arc</button>
                <button class="tab-btn" onclick="switchTab(2)">Sector</button>
                <button class="tab-btn" onclick="switchTab(3)">Segment</button>
            </div>

            <div id="tab0" class="tab-content active">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⭕ Basic Circle</h3>
                <div class="input-section">
                    <label>Calculate from</label>
                    <select id="inputType" onchange="updateInput()">
                        <option value="radius">Radius</option>
                        <option value="diameter">Diameter</option>
                        <option value="circumference">Circumference</option>
                        <option value="area">Area</option>
                    </select>
                </div>
                <div class="input-section">
                    <label id="inputLabel">Radius</label>
                    <input type="number" id="inputValue" value="5" step="any">
                </div>
                <button class="btn" onclick="calcBasic()">Calculate</button>
            </div>

            <div id="tab1" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">📏 Arc Length</h3>
                <div class="input-section">
                    <label>Radius</label>
                    <input type="number" id="arcR" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Angle (degrees)</label>
                    <input type="number" id="arcA" value="90" step="any">
                </div>
                <button class="btn" onclick="calcArc()">Calculate</button>
            </div>

            <div id="tab2" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">◔ Sector</h3>
                <div class="input-section">
                    <label>Radius</label>
                    <input type="number" id="secR" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Angle (degrees)</label>
                    <input type="number" id="secA" value="90" step="any">
                </div>
                <button class="btn" onclick="calcSector()">Calculate</button>
            </div>

            <div id="tab3" class="tab-content">
                <h3 style="color: #667eea; margin-bottom: 12px; font-size: 1.1rem;">⌓ Segment</h3>
                <div class="input-section">
                    <label>Radius</label>
                    <input type="number" id="segR" value="5" step="any">
                </div>
                <div class="input-section">
                    <label>Angle (degrees)</label>
                    <input type="number" id="segA" value="90" step="any">
                </div>
                <button class="btn" onclick="calcSegment()">Calculate</button>
            </div>

            <div class="result-section" id="result">
                <h3>📊 Results</h3>
                <div id="output"></div>
            </div>
        </div>

        <div class="info-box">
            <h3>📖 Circle Formulas</h3>
            <div class="formula-box">
                <strong>Basic:</strong>
                A = πr² | C = 2πr | d = 2r
            </div>
            <div class="formula-box">
                <strong>Arc & Sector:</strong>
                Arc = (θ/360)×2πr | Sector = (θ/360)×πr²
            </div>
            <div class="formula-box">
                <strong>Segment:</strong>
                Area = r²(θ - sinθ)/2 | Chord = 2r sin(θ/2)
            </div>
        </div>
    </div>

    <script>
        const PI = Math.PI;
        function switchTab(i) {
            document.querySelectorAll('.tab-btn').forEach((b,j)=>b.className=j===i?'tab-btn active':'tab-btn');
            document.querySelectorAll('.tab-content').forEach((c,j)=>c.className=j===i?'tab-content active':'tab-content');
            document.getElementById('result').classList.remove('show');
        }
        function updateInput() {
            const t = document.getElementById('inputType').value;
            const l = {radius:'Radius',diameter:'Diameter',circumference:'Circumference',area:'Area'}[t];
            document.getElementById('inputLabel').textContent = l;
        }
        function fmt(n) { return n.toFixed(+document.getElementById('decimals').value); }
        function unit() { return document.getElementById('unit').value; }
        function show(h) {
            document.getElementById('output').innerHTML = h;
            document.getElementById('result').classList.add('show');
        }
        function calcBasic() {
            const t = document.getElementById('inputType').value;
            const v = +document.getElementById('inputValue').value;
            const u = unit();
            if(isNaN(v)||v<=0) return alert('⚠️ Enter valid number');
            let r;
            if(t==='radius')r=v;
            else if(t==='diameter')r=v/2;
            else if(t==='circumference')r=v/(2*PI);
            else r=Math.sqrt(v/PI);
            const d=2*r,c=2*PI*r,a=PI*r*r;
            show(`<div class="result-box"><div class="result-label">Radius</div><div class="result-value">${fmt(r)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#2196F3;"><div class="result-label">Diameter</div><div class="result-value" style="color:#2196F3;">${fmt(d)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#FF9800;"><div class="result-label">Circumference</div><div class="result-value" style="color:#FF9800;">${fmt(c)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#9C27B0;"><div class="result-label">Area</div><div class="result-value" style="color:#9C27B0;">${fmt(a)} ${u}²</div></div>
            <div class="formula-box" style="background:#e8f5e9;border-left-color:#4CAF50;"><strong style="color:#4CAF50;">Formulas:</strong>A = πr² = ${fmt(a)} ${u}² | C = 2πr = ${fmt(c)} ${u}</div>`);
        }
        function calcArc() {
            const r=+document.getElementById('arcR').value,a=+document.getElementById('arcA').value,u=unit();
            if(isNaN(r)||isNaN(a)||r<=0||a<=0) return alert('⚠️ Enter valid numbers');
            const rad=a*PI/180,arc=r*rad,chord=2*r*Math.sin(rad/2);
            show(`<div class="result-box"><div class="result-label">Arc Length</div><div class="result-value">${fmt(arc)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#2196F3;"><div class="result-label">Chord Length</div><div class="result-value" style="color:#2196F3;">${fmt(chord)} ${u}</div></div>
            <div class="formula-box"><strong>Formula:</strong>Arc = rθ = ${r}×${rad.toFixed(4)} = ${fmt(arc)} ${u}</div>`);
        }
        function calcSector() {
            const r=+document.getElementById('secR').value,a=+document.getElementById('secA').value,u=unit();
            if(isNaN(r)||isNaN(a)||r<=0||a<=0) return alert('⚠️ Enter valid numbers');
            const rad=a*PI/180,area=(a/360)*PI*r*r,arc=r*rad,peri=2*r+arc;
            show(`<div class="result-box"><div class="result-label">Sector Area</div><div class="result-value">${fmt(area)} ${u}²</div></div>
            <div class="result-box" style="border-left-color:#2196F3;"><div class="result-label">Arc Length</div><div class="result-value" style="color:#2196F3;">${fmt(arc)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#FF9800;"><div class="result-label">Perimeter</div><div class="result-value" style="color:#FF9800;">${fmt(peri)} ${u}</div></div>
            <div class="formula-box"><strong>Formula:</strong>Area = (θ/360)×πr² = ${fmt(area)} ${u}²</div>`);
        }
        function calcSegment() {
            const r=+document.getElementById('segR').value,a=+document.getElementById('segA').value,u=unit();
            if(isNaN(r)||isNaN(a)||r<=0||a<=0) return alert('⚠️ Enter valid numbers');
            const rad=a*PI/180,area=(r*r/2)*(rad-Math.sin(rad)),chord=2*r*Math.sin(rad/2),h=r*(1-Math.cos(rad/2));
            show(`<div class="result-box"><div class="result-label">Segment Area</div><div class="result-value">${fmt(area)} ${u}²</div></div>
            <div class="result-box" style="border-left-color:#2196F3;"><div class="result-label">Chord Length</div><div class="result-value" style="color:#2196F3;">${fmt(chord)} ${u}</div></div>
            <div class="result-box" style="border-left-color:#FF9800;"><div class="result-label">Height</div><div class="result-value" style="color:#FF9800;">${fmt(h)} ${u}</div></div>
            <div class="formula-box"><strong>Formula:</strong>Area = r²(θ - sinθ)/2 = ${fmt(area)} ${u}²</div>`);
        }
    </script>
</body>
</html>