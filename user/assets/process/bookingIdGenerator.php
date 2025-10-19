<?php

/**
 * Booking ID Generator
 * Generates unique booking IDs in format: BLAZE + YYMMDD + 3 random digits
 * Example: BLAZE251019874
 */

class BookingIdGenerator
{
    /**
     * Generate a unique booking ID
     * Format: BLAZE + YYMMDD + 3 random digits
     * 
     * @return string
     */
    public static function generateBookingId()
    {
        // Get current date in YYMMDD format
        $datePart = date('ymd');
        
        // Generate 3 random digits
        $randomPart = str_pad(mt_rand(0, 999), 3, '0', STR_PAD_LEFT);
        
        // Combine: BLAZE + YYMMDD + 3 random digits
        $bookingId = 'BLAZE' . $datePart . $randomPart;
        
        return $bookingId;
    }
    
    /**
     * Generate a unique booking ID and ensure it doesn't exist in database
     * 
     * @param mysqli $connection Database connection
     * @return string Unique booking ID
     */
    public static function generateUniqueBookingId($connection)
    {
        $maxAttempts = 10; // Prevent infinite loop
        $attempts = 0;
        
        do {
            $bookingId = self::generateBookingId();
            $attempts++;
            
            // Check if booking ID already exists (now checking the id column)
            $checkQuery = "SELECT COUNT(*) as count FROM booking WHERE id = ?";
            $stmt = $connection->prepare($checkQuery);
            $stmt->bind_param("s", $bookingId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
            
            if ($row['count'] == 0) {
                return $bookingId; // Unique ID found
            }
            
        } while ($attempts < $maxAttempts);
        
        // If we couldn't generate a unique ID after max attempts, 
        // append timestamp to ensure uniqueness
        $timestamp = substr(microtime(), 2, 6);
        return 'BLAZE' . date('ymd') . $timestamp;
    }
    
    /**
     * Validate booking ID format
     * 
     * @param string $bookingId
     * @return bool
     */
    public static function isValidBookingId($bookingId)
    {
        // Check if format matches: BLAZE + 6 digits (YYMMDD) + 3 digits
        return preg_match('/^BLAZE\d{9}$/', $bookingId);
    }
    
    /**
     * Extract date from booking ID
     * 
     * @param string $bookingId
     * @return string|null Date in Y-m-d format or null if invalid
     */
    public static function extractDateFromBookingId($bookingId)
    {
        if (!self::isValidBookingId($bookingId)) {
            return null;
        }
        
        // Extract YYMMDD part (characters 5-10)
        $datePart = substr($bookingId, 5, 6);
        
        // Convert YY to full year (assuming 20YY)
        $year = '20' . substr($datePart, 0, 2);
        $month = substr($datePart, 2, 2);
        $day = substr($datePart, 4, 2);
        
        // Validate date
        if (checkdate($month, $day, $year)) {
            return $year . '-' . $month . '-' . $day;
        }
        
        return null;
    }
}
