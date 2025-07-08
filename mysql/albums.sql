USE album_sales_db;

-- 1. TOTAL NUMBER OF ALBUMS PER ARTIST
SELECT 
    artist,
    COUNT(*) as total_albums
FROM album_sales 
GROUP BY artist;

-- 2. COMBINED ALBUM SALES PER ARTIST (DETAILED)
SELECT 
    artist,
    COUNT(*) as album_count,
    SUM(sales_2022) as combined_sales,
    FORMAT(SUM(sales_2022), 0) as formatted_combined_sales
FROM album_sales 
GROUP BY artist 
ORDER BY combined_sales DESC;

-- 3. TOP 1 ARTIST WITH HIGHEST COMBINED SALES
SELECT 
    artist as top_selling_artist,
    COUNT(*) as total_albums,
    SUM(sales_2022) as highest_combined_sales,
    FORMAT(SUM(sales_2022), 0) as formatted_sales
FROM album_sales 
GROUP BY artist 
ORDER BY highest_combined_sales DESC 
LIMIT 1;

-- 4. TOP 10 ALBUMS PER YEAR BY SALES
WITH yearly_rankings AS (
    SELECT 
        YEAR(date_released) as release_year,
        artist,
        album,
        sales_2022,
        date_released,
        ROW_NUMBER() OVER (PARTITION BY YEAR(date_released) ORDER BY sales_2022 DESC) as rank_in_year
    FROM album_sales 
    WHERE date_released IS NOT NULL
)
SELECT 
    release_year,
    rank_in_year,
    artist,
    album,
    sales_2022,
    FORMAT(sales_2022, 0) as formatted_sales,
    date_released
FROM yearly_rankings 
WHERE rank_in_year <= 10
ORDER BY release_year DESC, rank_in_year ASC;

-- 5. SEARCH ALBUMS BY ARTIST (FLEXIBLE SEARCH)
SELECT 
    artist,
    album,
    sales_2022,
    FORMAT(sales_2022, 0) as formatted_sales,
    date_released
FROM album_sales 
WHERE artist = 'Yuju'
ORDER BY sales_2022 DESC;
