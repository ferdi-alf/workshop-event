// File: resources/js/chart-to-image.js
const puppeteer = require("puppeteer");
const fs = require("fs");

async function generateChartImage(htmlPath, outputPath) {
    let browser;

    try {
        // Launch browser
        browser = await puppeteer.launch({
            headless: "new",
            args: [
                "--no-sandbox",
                "--disable-setuid-sandbox",
                "--disable-dev-shm-usage",
                "--disable-gpu",
            ],
        });

        const page = await browser.newPage();

        // Set viewport untuk konsistensi
        await page.setViewport({
            width: 800,
            height: 600,
            deviceScaleFactor: 2, // Untuk kualitas HD
        });

        // Load HTML file
        const htmlContent = fs.readFileSync(htmlPath, "utf8");
        await page.setContent(htmlContent, {
            waitUntil: "networkidle0",
        });

        // Wait untuk chart selesai render
        await page.waitForFunction(
            () => {
                return (
                    document.body.getAttribute("data-chart-ready") === "true"
                );
            },
            { timeout: 10000 }
        );

        // Extra wait untuk memastikan animasi selesai
        await page.waitForTimeout(1000);

        // Screenshot chart container
        const chartContainer = await page.$("#chartContainer");
        if (chartContainer) {
            await chartContainer.screenshot({
                path: outputPath,
                type: "png",
                omitBackground: true,
            });
            console.log("Chart image generated successfully: " + outputPath);
        } else {
            throw new Error("Chart container not found");
        }
    } catch (error) {
        console.error("Error generating chart image:", error);
        process.exit(1);
    } finally {
        if (browser) {
            await browser.close();
        }
    }
}

// Get command line arguments
const htmlPath = process.argv[2];
const outputPath = process.argv[3];

if (!htmlPath || !outputPath) {
    console.error("Usage: node chart-to-image.js <html-file> <output-image>");
    process.exit(1);
}

// Generate chart image
generateChartImage(htmlPath, outputPath);
