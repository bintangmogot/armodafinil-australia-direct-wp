const puppeteer = require('puppeteer');
const { createObjectCsvWriter } = require('csv-writer');

const BASE_URL = 'https://www.armodafinil.com.au';

async function scrape() {
    console.log('Starting browser...');
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    
    console.log(`Navigating to ${BASE_URL}/product...`);
    await page.goto(`${BASE_URL}/product`, { waitUntil: 'networkidle2' });
    
    // Find all product links
    const productLinks = await page.evaluate(() => {
        // Find links that look like /product/something
        const links = Array.from(document.querySelectorAll('a[href^="/product/"]'));
        return [...new Set(links.map(a => a.href))].filter(href => href.split('/').length > 4); // basic filter to avoid /product itself
    });
    
    console.log(`Found ${productLinks.length} products. Extracting details...`);
    
    const products = [];
    
    for (const link of productLinks) {
        console.log(`Scraping: ${link}`);
        try {
            await page.goto(link, { waitUntil: 'networkidle2' });
            
            // Wait a moment for any client-side rendering (like tabs)
            await new Promise(r => setTimeout(r, 1000));

            // Extract product data
            const product = await page.evaluate(() => {
                const title = document.querySelector('h1')?.innerText || 'Unknown Product';
                
                // Find price
                const h1 = document.querySelector('h1');
                let regular_price = '';
                if (h1 && h1.nextElementSibling) {
                    const priceText = h1.nextElementSibling.innerText;
                    if (priceText.includes('$')) {
                         regular_price = priceText.match(/\$?([0-9,.]+)/)?.[1] || '';
                    }
                }
                
                // Get main image
                const imgs = Array.from(document.querySelectorAll('img')).filter(img => !img.src.includes('website_logo') && !img.src.includes('icon'));
                let image_url = imgs.length > 0 ? imgs[0].src : '';
                
                // Extract description from tabs
                let description = '';
                const tabPanels = document.querySelectorAll('[role="tabpanel"], .prose'); // typically tabs use role=tabpanel
                
                if (tabPanels.length > 0) {
                    // Try to click each tab and grab its content, but if they are in DOM just hidden, 
                    // we can just grab their text or HTML.
                    description = Array.from(tabPanels).map(t => t.innerHTML).join('<br><br>');
                } else {
                    // Fallback to main content section if tabs aren't explicitly marked
                    const article = document.querySelector('article') || document.querySelector('main');
                    if (article) {
                       description = article.innerHTML;
                    }
                }
                
                return {
                    Type: 'simple',
                    Name: title,
                    'Regular price': regular_price,
                    Images: image_url,
                    Description: description,
                    Categories: 'Medication' // Default category
                };
            });
            products.push(product);
        } catch (e) {
            console.error(`Error scraping ${link}:`, e.message);
        }
    }
    
    console.log('Scraping finished. Writing CSV...');
    await browser.close();
    
    const csvWriter = createObjectCsvWriter({
        path: 'final_woocommerce_import_from_live_site.csv',
        header: [
            { id: 'Type', title: 'Type' },
            { id: 'Name', title: 'Name' },
            { id: 'Regular price', title: 'Regular price' },
            { id: 'Images', title: 'Images' },
            { id: 'Description', title: 'Description' },
            { id: 'Categories', title: 'Categories' }
        ]
    });
    
    await csvWriter.writeRecords(products);
    console.log('CSV created successfully as final_woocommerce_import_from_live_site.csv');
}

scrape().catch(console.error);
