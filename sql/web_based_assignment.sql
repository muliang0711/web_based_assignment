-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 25, 2025 at 04:07 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `web_based_assignment`
--
CREATE DATABASE IF NOT EXISTS `web_based_assignment` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `web_based_assignment`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` varchar(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `department` enum('SA','IT','IN','CS','PD','TS','FI') NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `adminLevel` enum('main','staff') NOT NULL,
  `status` enum('Active','Blocked') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `department`, `passwordHash`, `adminLevel`, `status`) VALUES
('A001', 'Alice Wong', 'SA', '$2y$10$5Y2WIZtHCoElCeI6IXp94.4TiLKeTcbOK5AgTswY9oAwbFw9FViFi', 'main', 'Active'),
('A002', 'Bob Tan', 'IT', '$2y$10$2ioQwFoTCz3dH1AjoKG7NuOAHqKjzmecG7b.8BPW5aGiuImR9oji2', 'staff', 'Active'),
('A003', 'Charlie Lim', 'CS', '$2y$10$AeTa6/0xSoeDf2gz0.bXE.i1/kG56Alerke8pFPhe9NSVBVOKA3wi', 'main', 'Active'),
('A004', 'Daphne Teo', 'PD', '$2y$10$rYBjsAfzbPMGCn4MANIZ.ef78dfu/MnSbq8RwOKHnY272KCo9h8gK', 'staff', 'Blocked'),
('A005', 'Hannah Yeo', 'TS', '$2y$10$.2ZxTbzEPRnm0H9EYwJQnOG2YBQL8plEmxN3K7WzIAJHO1FUUYVFW', 'staff', 'Blocked');

-- --------------------------------------------------------

--
-- Table structure for table `blockeduser`
--

DROP TABLE IF EXISTS `blockeduser`;
CREATE TABLE `blockeduser` (
  `blockedUserID` varchar(15) NOT NULL,
  `role` enum('user','staff') NOT NULL,
  `blockedReason` varchar(30) DEFAULT NULL,
  `status` enum('-','reject','request') NOT NULL,
  `appealReason` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cartitem`
--

DROP TABLE IF EXISTS `cartitem`;
CREATE TABLE `cartitem` (
  `userID` int(11) NOT NULL,
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cartitem`
--

INSERT INTO `cartitem` (`userID`, `productID`, `sizeID`, `quantity`) VALUES
(2, 'R0001', '4UG5', 2),
(2, 'R0002', '4UG5', 3),
(2, 'R0003', '4UG5', 3),
(2, 'R0004', '4UG5', 5),
(2, 'R0005', '4UG5', 4);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `orderId` int(5) NOT NULL,
  `userId` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `orderAddress` varchar(150) NOT NULL,
  `orderName` varchar(40) NOT NULL,
  `orderPhone` varchar(15) NOT NULL,
  `deliveryMethod` varchar(20) NOT NULL,
  `deliveredDate` date DEFAULT NULL,
  `tracking` int(30) DEFAULT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `notify` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderId`, `userId`, `orderDate`, `status`, `orderAddress`, `orderName`, `orderPhone`, `deliveryMethod`, `deliveredDate`, `tracking`, `discount`, `notify`) VALUES
(1, 1, '2025-03-31', 'Canceled', 'PV18 RESIDENCE, JALAN LANGKAWI, 53000, Kuala Lumpur', 'Wayne Gan', '60126289399', 'Standard', NULL, 0, 119.70, 1),
(2, 1, '2025-04-23', 'Pending', 'Straits Court, JALAN Ujong pasir, 75050, Melaka', 'MR lolipop', '60126289399', 'Standard', NULL, 1, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `orderId` int(5) NOT NULL,
  `productId` varchar(5) NOT NULL,
  `quantity` int(10) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `gripSize` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`orderId`, `productId`, `quantity`, `subtotal`, `gripSize`) VALUES
(1, 'R0005', 1, 399.00, '3UG5'),
(2, 'R0060', 1, 199.00, '3UG5');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `productID` varchar(5) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `price` float(6,2) NOT NULL,
  `seriesID` varchar(3) DEFAULT NULL,
  `introduction` varchar(1000) NOT NULL,
  `playerInfo` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `productName`, `price`, `seriesID`, `introduction`, `playerInfo`) VALUES
('R0001', 'AeroSharp 11', 499.00, 'AS', 'Precision meets mastery with the AeroSharp 11. Designed for players who dictate the pace of the game, this racket offers superior shuttle control, effortless net play, and unmatched accuracy. The ultra-thin shaft and aerodynamic frame reduce drag, ensuring maximum maneuverability for the smartest players on the court.', 'Ethan Cheng. A tactical genius, Ethan is known for his surgical net drops and pinpoint clears. He controls rallies with calm precision, forcing opponents into mistakes before delivering the final blow.'),
('R0002', 'TurboSmash 1000', 599.00, 'TSM', 'Speed redefined. The TurboSmash 1000 is built for lightning-fast reactions and rapid counterattacks. With an ultra-lightweight frame and enhanced repulsion technology, this racket enables players to unleash quick drives and rapid smashes with ease. Perfect for those who thrive on pace and aggression.', 'Kei Tanaka. With his lightning footwork and relentless attacking style, Kei overwhelms opponents before they can react. His signature double-tap drive keeps defenders scrambling to keep up.'),
('R0003', 'ThunderStrike 88 max', 459.00, 'TST', 'Pure dominance on the court. The ThunderStrike 88 Max is designed for explosive power, engineered with an extra-stiff shaft and head-heavy balance to deliver devastating smashes. Whether attacking from the baseline or finishing at the net, this racket turns every shot into a statement.', 'Aleksandr Ivanov. A powerhouse with a smash that echoes across arenas, Aleksandr thrives on brute force. His signature \"Iron Hammer\" smash has made him a feared opponent worldwide.'),
('R0004', 'ThunderStrike 100', 679.00, 'TST', 'For those who demand control over raw power, the ThunderStrike 100 balances explosive smashes with excellent shot placement. The reinforced T-joint and optimized frame weight create a racket that delivers controlled aggression, allowing powerful yet precise play.', 'Leo Park. A relentless attacker with a strategic mind, Leo mixes powerful smashes with deceptive drop shots, making him unpredictable and deadly in any rally.'),
('R0005', 'Shadow Z', 399.00, 'SHD', 'A perfect fusion of speed and strength, the Shadow Z is built for aggressive players who need both lightning-fast reactions and crushing power. With a revolutionary hybrid frame and reinforced carbon core, this racket ensures rapid-fire play without sacrificing stability.', 'Nathan Cole. A bold, risk-taking player, Nathan’s agility and attacking prowess keep opponents constantly guessing. His signature \"Phantom Smash\"—a deceptive half-smash disguised as a full-power shot—has won him countless matches.'),
('R0006', 'ThunderStrike 99 max', 519.00, 'TST', 'The evolution of power. The ThunderStrike 99 is crafted for relentless attackers who aim to dominate the game. Its high-tension frame and reinforced shaft provide the ultimate combination of stability and power, making it the ultimate weapon for smash-heavy players.', 'Rajat Sharma, known as the \"Wall Breaker,\" Rajat’s smashes have been recorded at over 400 km/h. His aggressive baseline game and ruthless net kills make him an unstoppable force.'),
('R0007', 'AeroSharp 12', 509.00, 'AS', 'An evolution in precision play, the AeroSharp 12 enhances shot accuracy and net finesse. With its balanced frame and ultra-responsive shaft, it caters to tactical players who control tempo and flow.', 'Maya Liu. A quiet strategist, Maya dismantles opponents with graceful footwork and sharp placements, outthinking rather than overpowering.'),
('R0008', 'TurboSmash 1100', 609.00, 'TSM', 'Built for the relentless, the TurboSmash 1100 adds torque-enhanced flexibility for maximum shuttle repulsion. Rapid-fire rallies and back-to-back attacks are its specialty.', 'Kenji Watanabe. Known for his whirlwind style, Kenji’s explosive counters and unstoppable smashes leave no room for hesitation.'),
('R0009', 'ThunderStrike 90', 489.00, 'TST', 'Blending muscle with mobility, the ThunderStrike 90 provides a versatile mix of punch and responsiveness. A racket for players who dominate with strength and speed.', 'Carlos Méndez. An all-court powerhouse, Carlos rains down smashes from all angles, keeping defenders on the run.'),
('R0010', 'Shadow Z2', 429.00, 'SHD', 'The Shadow Z2 adds flex-engineered layers for improved shot recovery and mid-rally power. Designed for explosive play without losing court control.', 'Leila Arif. Unpredictable and fast, Leila confuses with feints and strikes with force. Her style: chaos refined.'),
('R0011', 'AeroSharp X', 549.00, 'AS', 'A pinnacle of finesse, the AeroSharp X integrates carbon-weave technology for elite shuttle control and net precision. Ideal for master tacticians.', 'Damien Zhou. Nicknamed “The Chessmaster,” Damien’s every shot is calculated and cold-blooded.'),
('R0012', 'TurboSmash 1200', 619.00, 'TSM', 'TurboSmash 1200 elevates aggression with a hyper-tensile shaft and lightning frame. Created for rapid play transitions and relentless front-court offense.', 'Sofia Blanco. Blazing speed and relentless energy make Sofia a one-woman highlight reel.'),
('R0013', 'ThunderStrike Titan', 699.00, 'TST', 'Unmatched in brute force, the Titan version features a reinforced graphite core and edge-tuned headweight for thunderous delivery.', 'Omar Singh. Pure carnage on court, Omar brings sheer power with calculated destruction.'),
('R0014', 'Shadow ZX', 459.00, 'SHD', 'Blending power and swiftness, the Shadow ZX includes dual-flex zones and an anti-vibration grip, perfect for quick hitters who can strike from nowhere.', 'Tanya Lin. Fast as a shadow, Tanya weaves through rallies like smoke—then strikes like lightning.'),
('R0015', 'AeroSharp Elite', 579.00, 'AS', 'Crafted for shot artists, the Elite version upgrades responsiveness and tactical control with a precision-balanced shaft.', 'Julian Hart. A magician on court, Julian sees gaps others miss and exploits them with surgical touch.'),
('R0016', 'TurboSmash Blaze', 639.00, 'TSM', 'The Blaze model boosts kinetic repulsion and edge-light structure, allowing unrelenting firepower without exhausting control.', 'Freya Novak. Her fiery style leaves no rally untouched by chaos, and her smash-speed record is unmatched.'),
('R0017', 'ThunderStrike Nova', 509.00, 'TST', 'Nova delivers cosmic power with enhanced torsion control and anti-twist core. A go-to for players seeking heavy offense with fine-tuned control.', 'Arjun Patel. A rising star with galactic smashes and a calm head—Arjun strikes with force and focus.'),
('R0018', 'Shadow Z3', 449.00, 'SHD', 'Z3 upgrades the Shadow legacy with kinetic mesh grip and rapid-flex strings. Built for players who strike hard without warning.', 'Camila Torres. Her sudden drops and smash counters make every rally feel like walking a tightrope.'),
('R0019', 'AeroSharp Nova', 529.00, 'AS', 'With reactive frame balancing and swift recovery mechanics, the AeroSharp Nova brings aerial command and shot anticipation to new heights.', 'Min-Ho Kim. Master of flow, Min-Ho glides from shot to shot with effortless rhythm and quiet control.'),
('R0020', 'TurboSmash Neo', 649.00, 'TSM', 'The Neo edition adds vibration-dampening tech and jet-thrust architecture for smooth yet ferocious play.', 'Rina Yamada. Sleek and fast, Rina’s cross-court power and snappy net play dazzle crowds.'),
('R0021', 'ThunderStrike Edge', 469.00, 'TST', 'Designed for relentless court pressure, the Edge adds cut-resist grommets and torque-lock control zones for ultra-stable shot production.', 'Victor Lau. His relentless pressure and pinpoint timing break through the tightest defenses.'),
('R0022', 'Shadow Z Pro', 499.00, 'SHD', 'Advanced rebound layering and split-torque control make the Z Pro a top-tier choice for high-speed aggression with touch finesse.', 'Sara Jang. Elegant but dangerous, Sara makes the impossible shot look routine.'),
('R0023', 'AeroSharp Vision', 489.00, 'AS', 'Built for predictive play, Vision uses intuitive weight mapping and neutral balance for high precision in tight spaces.', 'Elijah Brooks. A calm storm on the court, Elijah anticipates the play three moves ahead.'),
('R0024', 'TurboSmash Infinity', 659.00, 'TSM', 'Unlimited potential with the Infinity dual-energy core and aero-rebound tech. A beast for extreme offense and fast-paced transitions.', 'Yuki Matsuda. She never stops attacking—every shot is a new explosion.'),
('R0025', 'ThunderStrike Eclipse', 699.00, 'TST', 'Eclipse delivers blackout force with its ultra-dense graphite weave and reinforced shaft. For elite attackers only.', 'Andre Rousseau. The shadow striker, Andre lands every smash like a sledgehammer through space.'),
('R0026', 'Shadow Z Stealth', 479.00, 'SHD', 'The Stealth variant enhances frame acoustics and minimizes swing signature—perfect for players who thrive on surprise and precision.', 'Kira Nakamura. Invisible until it’s too late, Kira’s flicks and smashes seem to come from nowhere.'),
('R0027', 'AeroSharp Spirit', 509.00, 'AS', 'Spirit combines an energy-snap core with adaptive torsion for pinpoint rally control and explosive push shots.', 'Liam Ortega. With flair and finesse, Liam balances mind and muscle in perfect harmony.'),
('R0028', 'TurboSmash Spark', 619.00, 'TSM', 'Spark is raw fire. With acceleration-boost strings and carbon-fusion taper, it triggers fast attacks with electrifying feedback.', 'Emily Zhang. Her game is speed, spark, and no second chances.'),
('R0029', 'ThunderStrike Prime', 549.00, 'TST', 'Prime packs layered strength with ultra-stiff frame integrity for players who control pace through pressure and power.', 'Tobias Meier. Known as “The Engine,” Tobias just keeps going, applying constant, ruthless force.'),
('R0030', 'Shadow Z Alpha', 439.00, 'SHD', 'Alpha enhances the Shadow Z DNA with power-flex zones and layered tension control. Designed for quick-strike players who can turn defense into offense.', 'Amira Solis. Her game is all about timing—deflect, strike, and disappear.'),
('R0031', 'AeroSharp Delta', 529.00, 'AS', 'Delta introduces tri-phase frame engineering for sharp rotation speed and net-lock control, ideal for mid-court domination.', 'Lucas Brandt. A quiet competitor, Lucas works the court like a sculptor—every stroke deliberate, every shot beautiful.'),
('R0032', 'TurboSmash Hyper', 679.00, 'TSM', 'Hyper’s triple-core propulsion and drag-minimized shaft produce relentless pace with silky follow-through.', 'Natalie Reyes. Once she starts attacking, she doesn’t stop. Hyper-aggressive and fearless.'),
('R0033', 'ThunderStrike Alpha Max', 599.00, 'TST', 'Alpha Max adds a reinforced flex-bridge for counterpressure strength and maximum strike torque.', 'Felix Huang. Big energy, bigger hits. Felix owns the baseline like it’s his home turf.'),
('R0034', 'Shadow Z Omega', 489.00, 'SHD', 'Omega’s final form channels precision and pace, using gravity-tuned balance for excellent all-court utility.', 'Zoë Palmer. Tactical yet tenacious, Zoë adapts fast and finishes faster.'),
('R0035', 'AeroSharp Vision X', 559.00, 'AS', 'Vision X upgrades tactical dominance with dynamic weight mapping and reflex-core energy systems.', 'Ethan Rowe. Pure focus. Pure reflex. Ethan’s sharp reads and unflinching defense win rallies before they begin.'),
('R0036', 'TurboSmash Velocity', 649.00, 'TSM', 'Velocity rockets the shuttle with pulse-shot technology and kinetic tension rebound. A machine built for constant attack.', 'Chiara Rossi. Light-speed fast and ten steps ahead, Chiara disorients with pace and precision.'),
('R0037', 'ThunderStrike Raptor', 589.00, 'TST', 'Raptor adds aggressive head-weighting with fast recoil, enabling dominant aerial strikes and punishing kills.', 'Jalen Reed. He stalks the net, strikes from above, and never lets prey escape.'),
('R0038', 'Shadow Z Nova', 509.00, 'SHD', 'Nova harnesses a dual-balance core and amplified whip-flex for sudden, explosive rallies.', 'Nia Morgan. Calm and composed—until she isn’t. Her explosive transitions turn the tide in seconds.'),
('R0039', 'AeroSharp Ghost', 539.00, 'AS', 'Ghost cloaks motion and manipulates tempo with precision-flex memory and passive string tuning.', 'Kai Yamamoto. Subtle, stylish, and dangerous—his ghost shots blur the line between fake and real.'),
('R0040', 'TurboSmash Nitro', 669.00, 'TSM', 'Nitro’s explosive architecture and dynamic string bed create instant attack power for the most aggressive players.', 'Layla Khan. Her style is volatile, but when she’s on fire, there’s no stopping the barrage.'),
('R0041', 'ThunderStrike Omega', 639.00, 'TST', 'Omega upgrades torque control and elastic resonance tech for pinpoint power. Perfect for those who want to finish rallies with finality.', 'Maksim Volkov. Ruthless and robotic, Maksim dominates with mechanical precision.'),
('R0042', 'Shadow Z Strike', 499.00, 'SHD', 'Strike layers enhanced recoil channels and a speed-thin shaft for agile, powerful blows from every angle.', 'Serena Tan. The queen of transitions—she attacks from the back, the net, or mid-air with flawless instinct.'),
('R0043', 'AeroSharp Apex', 579.00, 'AS', 'Apex blends aerodynamic lift and micro-grip detail for tight control over flicks, taps, and net drives.', 'Tyrese Gordon. Smooth operator with no wasted movement—Tyrese flows like water, then cuts like a blade.'),
('R0044', 'TurboSmash Volt', 689.00, 'TSM', 'Volt charges every swing with reactive energy and ultra-dense coil rebound. Built for full-court explosiveness.', 'Ines Müller. Her electrifying playstyle sends sparks through every rally. One mistake, and it’s game over.'),
('R0045', 'Phantom Edge', 529.00, 'PHM', 'A racket shrouded in mystery and performance. The Phantom Edge introduces GhostFrame tech for reduced air resistance and spectral shot recovery. Designed for players who vanish and strike.', 'Noah Ryker. Elusive and calculating, Noah blends stealth with brilliance. His court presence is a riddle opponents cant solve.'),
('R0046', 'Phantom Core', 499.00, 'PHM', 'The Phantom Core is light, lethal, and responsive. With its soul-threaded shaft and energy recoil system, it enables deceptive play and lightning counters.', 'Isla Feng. Her signature style is misdirection—every stroke disguises her next devastating move.'),
('R0047', 'Phantom Vortex', 559.00, 'PHM', 'The Vortex spins opponents into confusion with twisted frame aerodynamics and chaotic shuttle spin control.', 'Zane Mitchell. Known as “The Illusionist,” Zane turns matches into psychological warfare.'),
('R0048', 'Phantom Ghost', 579.00, 'PHM', 'Designed for unseen domination, the Ghost is ultra-light yet deadly. Its FadeGrip handle and soft-release strings help mask swing intent.', 'Mei Sato. Silent on court, Mei strikes with eerie timing and untraceable finesse.'),
('R0049', 'Phantom Reaper', 599.00, 'PHM', 'The Reaper brings judgment in every shot. With spectral tension tech and control-boosting balance, it excels in rally execution and kill shots.', 'Darius Quinn. A legend of clutch moments, Darius’s opponents fear his cold-blooded final strikes.'),
('R0050', 'Phantom Mirage', 549.00, 'PHM', 'The Mirage creates visual deception with its mirrored frame coating and erratic shot feedback. A true weapon for tricksters and mind gamers.', 'Ayla Cruz. A flair-filled performer, Ayla dazzles crowds and opponents with feints, flicks, and unexplainable winners.'),
('R0051', 'Phantom Vibe', 379.00, 'PHM', 'Designed for silent speed, the Phantom Vibe is ultra-maneuverable with a low vibration core. Great for players who outpace rather than overpower.', 'Noah Lin. A smooth and steady rhythm defines his play—never rushed, always in control.'),
('R0052', 'Phantom X', 429.00, 'PHM', 'The Phantom X combines deceptive flex and quick-snap power. Ideal for ambush-style rallies and surprise drives.', 'Aria Chen. Known for vanishing mid-rally and reappearing with a winner, Aria plays like a shadow.'),
('R0053', 'AeroSharp 5', 259.00, 'AS', 'An affordable option for rising tacticians, with a light shaft and reliable control.', 'Zane Wright. Young, quick-thinking, and calm—Zane’s strength lies in his precision.'),
('R0054', 'TurboSmash 600', 299.00, 'TSM', 'Budget-friendly speed with a responsive core, made for entry-level aggression.', 'Sanjay Kapoor. Bursting with energy, Sanjay brings a fast game and fearless attacks.'),
('R0055', 'ThunderStrike Core', 339.00, 'TST', 'Raw power at a low cost, with stiff flex and a focus on smash-heavy play.', 'Luca Petrović. A student of force, Luca is learning to wield power with discipline.'),
('R0056', 'Shadow Lite', 229.00, 'SHD', 'Speed-first racket for beginners and intermediate players who rely on quick footwork.', 'Emma Rae. Nimble and quick, she dashes across the court with a dancer’s grace.'),
('R0057', 'Phantom Flow', 289.00, 'PHM', 'Designed for elegant, deceptive movement. Flexible shaft helps launch surprise flicks and rolls.', 'Reina Matsuno. She glides like wind—barely seen, rarely touched.'),
('R0058', 'Phantom Ace', 349.00, 'PHM', 'A precision player’s racket, tuned for net play and drop shots, with stable handling.', 'Yusuf Idris. A specialist at the net, his touches leave opponents stunned.'),
('R0059', 'TurboSmash 700', 319.00, 'TSM', 'Solid speed and aggressive potential with beginner-friendly handling.', 'Chen Wei. Rising through the ranks, Chen combines smart angles with sneaky pace.'),
('R0060', 'AeroSharp Base', 199.00, 'AS', 'Entry-level AeroSharp model for players learning to control rallies and play smart.', 'Grace Romero. New to the game, but already showing flashes of sharp strategy.'),
('R0061', 'ThunderStrike Micro', 249.00, 'TST', 'A compact, high-rebound racket for learning players who love to hit hard.', 'Jason Moore. Small in size, big on power—Jason swings for the fences.'),
('R0062', 'Phantom Ghost', 409.00, 'PHM', 'A higher-end Phantom with tension-tuned strings and “silent whip” shaft. Deadly for precision strikers.', 'Isla Novak. Cool and unshakable, Isla’s winners come from nowhere.'),
('R0063', 'Shadow Edge', 269.00, 'SHD', 'Sharp and fast, Shadow Edge helps intermediate players push rallies with stealthy speed.', 'Devon Hill. Known for sneaky drop smashes and unmatched footwork.'),
('R0064', 'Phantom Shift', 319.00, 'PHM', 'Built for rhythm changes and play disruption. Balanced frame supports quick transitions.', 'Leo Zhang. Master of rhythm—he speeds up, slows down, and resets the rally at will.'),
('R0065', 'TurboSmash 300', 219.00, 'TSM', 'Simple, clean design for players who want a reliable attack-based racket at a low cost.', 'Natalie King. Learning fast, her smashes are getting harder and smarter every match.'),
('R0066', 'AeroSharp Light', 239.00, 'AS', 'Lightweight with modest flex—perfect for defensive-minded players on a budget.', 'Ravi Mehta. Focused on consistency, Ravi builds points shot by shot.'),
('R0067', 'Phantom Mirage', 389.00, 'PHM', 'Engineered for deception, with semi-stiff flex and high torsional response.', 'Hana Kim. Her shot fakes are legendary—nobody knows where it’s really going.'),
('R0068', 'ThunderStrike 70', 299.00, 'TST', 'Mid-tier power frame, good for developing smash technique and baseline drives.', 'Owen Carter. A raw attacker learning to harness timing and torque.'),
('R0069', 'Shadow Stryke', 369.00, 'SHD', 'Combines sudden burst power and sleek maneuverability. Perfect for quick strike players.', 'Jia Li. She sees patterns no one else sees—and punishes every opening.'),
('R0070', 'Phantom Zero', 199.00, 'PHM', 'Entry-level Phantom with whisper-frame tech and elastic shaft. Light, fast, and silent.', 'Ben Torres. A new Phantom disciple—he practices deception every day.'),
('R0071', 'AeroSharp Core', 219.00, 'AS', 'Sturdy core construction, tuned for control learning and baseline stability.', 'Niko Yamazaki. A thinker on court, always positioning for the next shot.'),
('R0072', 'TurboSmash Spin', 279.00, 'TSM', 'For players experimenting with aggressive lifts and rotating power.', 'Ayaka Shimizu. Loves a fast rally and a spinning drive.'),
('R0073', 'Phantom Hex', 359.00, 'PHM', 'Hexagonal frame edges reduce wind drag, maximizing disguise and swing speed.', 'Ibrahim Salem. Precision and stealth define his game—every movement intentional.'),
('R0074', 'Shadow Whisper', 249.00, 'SHD', 'Low-audio frame design and balanced tension ideal for subtle, controlled play.', 'Lila Morgan. A defensive wall with a killer instinct.'),
('R0075', 'ThunderStrike Basic', 229.00, 'TST', 'Intro-level strike power with balanced handling for learners.', 'Daniël Koenig. Quiet, focused, and determined to master the smash.'),
('R0076', 'Phantom Echo', 409.00, 'PHM', 'Designed for players who control tempo and rhythm, with delayed recoil frame response.', 'Chloe Ng. Her shots echo long after they land.'),
('R0077', 'AeroSharp Rise', 199.00, 'AS', 'Starter model for players learning touch control and court awareness.', 'Marko Silva. Learning fast, rising faster—his control game is coming together.'),
('R0078', 'TurboSmash Quick', 249.00, 'TSM', 'Compact grip and quick response, best for players working on fast rallies.', 'Nina Ivanova. Lightning hands and a love for tight net battles.'),
('R0079', 'Phantom Blade', 389.00, 'PHM', 'Sharp edges and stiffer flex give this racket a slice-through feel, great for fast winners.', 'Zaid Khan. A cutting-edge attacker who finishes points before they start.'),
('R0080', 'Shadow Delta', 299.00, 'SHD', 'Improved frame resilience and solid handling. Ideal for all-round intermediate players.', 'Fatima Rahman. Her balance and timing are deadly.'),
('R0081', 'ThunderStrike Flex', 279.00, 'TST', 'More forgiving flex shaft with head-heavy control for developing players.', 'Ezra Bell. He learns with every strike, slowly building his arsenal.'),
('R0082', 'Phantom Pulse', 379.00, 'PHM', 'Pulse tech amplifies contact feedback, aiding control in deceptive shots.', 'Aliyah Tan. Her pulse-sync rallies make her hard to predict.'),
('R0083', 'AeroSharp Tour', 319.00, 'AS', 'Tour-level handling with tight shaft response and net shot accuracy.', 'Ren Ito. On the edge of pro play, Ren perfects every detail.'),
('R0084', 'TurboSmash Jet', 339.00, 'TSM', 'Jet propulsion build with improved corner-to-corner speed.', 'Maddox Hayes. A blur on court—never still, always attacking.'),
('R0085', 'Shadow Vortex', 369.00, 'SHD', 'Vortex shaping adds twist energy and shot curve potential.', 'Tina Vos. Her control of spin and shape is a thing of beauty.'),
('R0086', 'Phantom Arc', 359.00, 'PHM', 'Arched frame with top-weighted flow—ideal for overhead deception and drop control.', 'Kaito Sugimoto. Every motion a disguise, every arc a trick.'),
('R0087', 'ThunderStrike StrikeLite', 249.00, 'TST', 'A light version of the classic strike series with manageable power.', 'Georgia Neal. Fast and feisty, learning to channel power in new ways.'),
('R0088', 'AeroSharp Reflex', 289.00, 'AS', 'Designed for fast-response counterplay and last-second saves.', 'Kiran Das. Reflexes sharp as a blade—he’s never caught sleeping.'),
('R0089', 'Phantom Nova', 399.00, 'PHM', 'Balanced and elegant, Nova blends clean flex with consistent shot return.', 'Sasha Petrov. Always graceful—until the moment she attacks.'),
('R0090', 'TurboSmash Lite', 219.00, 'TSM', 'Basic, speedy build with balanced grip and low swing weight.', 'Miguel Santos. A developing player, full of energy and drive.'),
('R0091', 'Phantom Line', 289.00, 'PHM', 'For players who draw the line between chaos and control.', 'Hailey Seo. She strikes only when the odds favor her—precise and poised.'),
('R0092', 'Shadow Phantom', 369.00, 'SHD', 'The most Phantom-inspired Shadow yet—flexible, fast, and fluid.', 'Jared Olsen. Smooth and steady, but lethal when provoked.'),
('R0093', 'AeroSharp Scout', 239.00, 'AS', 'Light, mobile and perfect for court coverage drills.', 'Yana Milosz. She never stops moving, always scouting for the next opening.'),
('R0094', 'ThunderStrike VoltLite', 289.00, 'TST', 'Volt series-inspired energy with lighter construction.', 'Luis Moreno. Young, strong, and learning to channel it all.'),
('R0095', 'Phantom Circuit', 349.00, 'PHM', 'Tuned for endurance and rally rhythm—consistency over chaos.', 'Zoe Armstrong. She’ll wear you down, then pick you apart.'),
('R0096', 'TurboSmash Pulse', 329.00, 'TSM', 'High-response strings for constant drive play.', 'Felipe Navarro. Always pressing the pace with nonstop rallies.'),
('R0097', 'Shadow Base', 199.00, 'SHD', 'Starter Shadow model built for entry-level agility and touch.', 'Camryn Lee. Fast feet, big dreams.'),
('R0098', 'Phantom Loop', 269.00, 'PHM', 'With spin-boost strings and counter-drag design, the Loop brings deceptive rally control.', 'Tariq Amin. Loves to grind out points with spin and placement.'),
('R0099', 'AeroSharp Neo', 289.00, 'AS', 'Sharp feel and nimble handling for advancing players.', 'Mina Kwon. Clean strokes and growing confidence.'),
('R0100', 'Phantom Rise', 319.00, 'PHM', 'Lightweight Phantom tuned for beginners ready to level up.', 'Jake Fields. Learning to rise, one swing at a time.');

-- --------------------------------------------------------

--
-- Table structure for table `productstock`
--

DROP TABLE IF EXISTS `productstock`;
CREATE TABLE `productstock` (
  `productID` varchar(5) NOT NULL,
  `sizeID` varchar(4) NOT NULL,
  `stock` int(11) NOT NULL,
  `status` enum('onsales','notonsales') NOT NULL DEFAULT 'notonsales',
  `low_stock_threshold` int(11) DEFAULT 5,
  `alert_sent` tinyint(1) DEFAULT 0,
  `qr_token` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `productstock`
--

INSERT INTO `productstock` (`productID`, `sizeID`, `stock`, `status`, `low_stock_threshold`, `alert_sent`, `qr_token`) VALUES
('R0001', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0001', '4UG5', 1, 'onsales', 5, 1, '9e22411d04b7c9b04584a1339265e142'),
('R0002', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0002', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0003', '3UG5', 2, 'onsales', 5, 1, 'f76d3e735389999bf414f1ca64b081bd'),
('R0003', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0004', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0004', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0005', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0005', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0006', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0006', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0007', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0007', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0008', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0008', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0009', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0009', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0010', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0010', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0011', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0011', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0012', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0012', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0013', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0013', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0014', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0014', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0015', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0015', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0016', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0016', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0017', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0017', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0018', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0018', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0019', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0019', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0020', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0020', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0021', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0021', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0022', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0022', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0023', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0023', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0024', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0024', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0025', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0025', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0026', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0026', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0027', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0027', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0028', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0028', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0029', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0029', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0030', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0030', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0031', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0031', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0032', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0032', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0033', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0033', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0034', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0034', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0035', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0035', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0036', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0036', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0037', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0037', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0038', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0038', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0039', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0039', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0040', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0040', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0041', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0041', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0042', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0042', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0043', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0043', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0044', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0044', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0045', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0045', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0046', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0046', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0047', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0047', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0048', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0048', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0049', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0049', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0050', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0050', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0051', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0051', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0052', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0052', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0053', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0053', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0054', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0054', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0055', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0055', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0056', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0056', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0057', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0057', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0058', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0058', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0059', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0059', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0060', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0060', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0061', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0061', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0062', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0062', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0063', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0063', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0064', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0064', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0065', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0065', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0066', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0066', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0067', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0067', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0068', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0068', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0069', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0069', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0070', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0070', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0071', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0071', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0072', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0072', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0073', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0073', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0074', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0074', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0075', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0075', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0076', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0076', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0077', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0077', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0078', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0078', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0079', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0079', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0080', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0080', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0081', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0081', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0082', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0082', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0083', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0083', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0084', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0084', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0085', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0085', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0086', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0086', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0087', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0087', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0088', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0088', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0089', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0089', '4UG5', 1, 'onsales', 5, 1, NULL),
('R0090', '3UG5', 5, 'onsales', 5, 1, NULL),
('R0090', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0091', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0091', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0092', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0092', '4UG5', 5, 'onsales', 5, 1, NULL),
('R0093', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0093', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0094', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0094', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0095', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0095', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0096', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0096', '4UG5', 4, 'onsales', 5, 1, NULL),
('R0097', '3UG5', 4, 'onsales', 5, 1, NULL),
('R0097', '4UG5', 5, 'onsales', 5, 0, NULL),
('R0098', '3UG5', 2, 'onsales', 5, 1, NULL),
('R0098', '4UG5', 3, 'onsales', 5, 1, NULL),
('R0099', '3UG5', 5, 'onsales', 5, 0, NULL),
('R0099', '4UG5', 6, 'onsales', 5, 0, NULL),
('R0100', '3UG5', 3, 'onsales', 5, 1, NULL),
('R0100', '4UG5', 4, 'onsales', 5, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

DROP TABLE IF EXISTS `product_images`;
CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `productID` varchar(50) DEFAULT NULL,
  `image_path` text NOT NULL,
  `image_type` enum('product','player') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `productID`, `image_path`, `image_type`, `created_at`) VALUES
(1, 'R0001', 'product_R0001_1745508667.png', 'product', '2025-04-18 14:30:37'),
(2, 'R0001', 'player_R0001_1745508667.png', 'player', '2025-04-18 14:30:37'),
(3, 'R0002', 'product_R0002_1743343876.png', 'product', '2025-03-30 14:11:16'),
(4, 'R0002', 'player_R0002_1743343876.png', 'player', '2025-03-30 14:11:16'),
(5, 'R0003', 'product_R0003_1743343896.png', 'product', '2025-03-30 14:11:36'),
(6, 'R0003', 'player_R0003_1743343896.png', 'player', '2025-03-30 14:11:36'),
(7, 'R0004', 'product_R0004_1743343915.png', 'product', '2025-03-30 14:11:55'),
(8, 'R0004', 'player_R0004_1743343915.png', 'player', '2025-03-30 14:11:55'),
(9, 'R0005', 'product_R0005_1743343932.png', 'product', '2025-03-30 14:12:12'),
(10, 'R0005', 'player_R0005_1743343932.png', 'player', '2025-03-30 14:12:12'),
(11, 'R0006', 'product_R0006_1743343950.png', 'product', '2025-03-30 14:12:30'),
(12, 'R0006', 'player_R0006_1743343950.png', 'player', '2025-03-30 14:12:30'),
(15, 'R0007', 'product_R0007_1744986951.png', 'product', '2025-04-18 14:35:51'),
(16, 'R0007', 'player_R0007_1744986951.jpg', 'player', '2025-04-18 14:35:51'),
(17, 'R0008', 'product_R0008_1744986995.png', 'product', '2025-04-18 14:36:35'),
(18, 'R0008', 'player_R0008_1744986995.png', 'player', '2025-04-18 14:36:35'),
(19, 'R0009', 'product_R0009_1744987030.png', 'product', '2025-04-18 14:37:10'),
(20, 'R0009', 'player_R0009_1744987030.png', 'player', '2025-04-18 14:37:10'),
(28, 'R0012', 'product_R0012_1744987230.png', 'product', '2025-04-18 14:40:30'),
(29, 'R0013', 'product_R0013_1744987251.png', 'product', '2025-04-18 14:40:51'),
(30, 'R0013', 'player_R0013_1744987251.png', 'player', '2025-04-18 14:40:51'),
(31, 'R0014', 'product_R0014_1744987299.png', 'product', '2025-04-18 14:41:39'),
(32, 'R0014', 'player_R0014_1744987299.png', 'player', '2025-04-18 14:41:39'),
(35, 'R0016', 'product_R0016_1744987346.png', 'product', '2025-04-18 14:42:26'),
(36, 'R0016', 'player_R0016_1744987346.png', 'player', '2025-04-18 14:42:26'),
(37, 'R0015', 'product_R0015_1744987493.png', 'product', '2025-04-18 14:44:53'),
(38, 'R0015', 'player_R0015_1744987493.png', 'player', '2025-04-18 14:44:53'),
(39, 'R0017', 'product_R0017_1744987571.png', 'product', '2025-04-18 14:46:11'),
(40, 'R0017', 'player_R0017_1744987571.png', 'player', '2025-04-18 14:46:11'),
(41, 'R0018', 'product_R0018_1744987612.png', 'product', '2025-04-18 14:46:52'),
(42, 'R0018', 'player_R0018_1744987612.png', 'player', '2025-04-18 14:46:52'),
(43, 'R0019', 'product_R0019_1744987625.png', 'product', '2025-04-18 14:47:05'),
(44, 'R0019', 'player_R0019_1744987625.png', 'player', '2025-04-18 14:47:05'),
(45, 'R0020', 'product_R0020_1744987639.png', 'product', '2025-04-18 14:47:19'),
(46, 'R0020', 'player_R0020_1744987639.png', 'player', '2025-04-18 14:47:19'),
(48, 'R0011', 'product_R0011_1744987703.png', 'product', '2025-04-18 14:48:23'),
(49, 'R0011', 'player_R0011_1744987703.png', 'player', '2025-04-18 14:48:23'),
(50, 'R0021', 'product_R0021_1744987787.png', 'product', '2025-04-18 14:49:47'),
(51, 'R0021', 'player_R0021_1744987787.png', 'player', '2025-04-18 14:49:47'),
(52, 'R0022', 'product_R0022_1744987820.png', 'product', '2025-04-18 14:50:20'),
(53, 'R0022', 'player_R0022_1744987820.jpg', 'player', '2025-04-18 14:50:20'),
(54, 'R0023', 'product_R0023_1744988036.png', 'product', '2025-04-18 14:53:56'),
(55, 'R0023', 'player_R0023_1744988036.png', 'player', '2025-04-18 14:53:56'),
(56, 'R0024', 'product_R0024_1744988049.png', 'product', '2025-04-18 14:54:09'),
(57, 'R0024', 'player_R0024_1744988049.png', 'player', '2025-04-18 14:54:09'),
(58, 'R0025', 'product_R0025_1744988061.png', 'product', '2025-04-18 14:54:21'),
(59, 'R0025', 'player_R0025_1744988061.png', 'player', '2025-04-18 14:54:21'),
(60, 'R0026', 'product_R0026_1744988119.png', 'product', '2025-04-18 14:55:19'),
(61, 'R0026', 'player_R0026_1744988119.png', 'player', '2025-04-18 14:55:19'),
(62, 'R0027', 'product_R0027_1744988140.png', 'product', '2025-04-18 14:55:40'),
(63, 'R0027', 'player_R0027_1744988140.png', 'player', '2025-04-18 14:55:40'),
(64, 'R0028', 'product_R0028_1744988173.png', 'product', '2025-04-18 14:56:13'),
(65, 'R0028', 'player_R0028_1744988173.png', 'player', '2025-04-18 14:56:13'),
(66, 'R0029', 'product_R0029_1744988189.png', 'product', '2025-04-18 14:56:29'),
(67, 'R0029', 'player_R0029_1744988189.png', 'player', '2025-04-18 14:56:29'),
(68, 'R0030', 'product_R0030_1744988204.png', 'product', '2025-04-18 14:56:44'),
(69, 'R0030', 'player_R0030_1744988204.png', 'player', '2025-04-18 14:56:44'),
(70, 'R0031', 'product_R0031_1744988305.png', 'product', '2025-04-18 14:58:25'),
(71, 'R0031', 'player_R0031_1744988305.png', 'player', '2025-04-18 14:58:25'),
(72, 'R0032', 'product_R0032_1744988322.png', 'product', '2025-04-18 14:58:42'),
(73, 'R0032', 'player_R0032_1744988322.png', 'player', '2025-04-18 14:58:42'),
(74, 'R0033', 'product_R0033_1744988333.png', 'product', '2025-04-18 14:58:53'),
(75, 'R0033', 'player_R0033_1744988333.png', 'player', '2025-04-18 14:58:53'),
(76, 'R0034', 'product_R0034_1744988350.png', 'product', '2025-04-18 14:59:10'),
(77, 'R0034', 'player_R0034_1744988350.png', 'player', '2025-04-18 14:59:10'),
(78, 'R0035', 'product_R0035_1744988361.png', 'product', '2025-04-18 14:59:21'),
(79, 'R0035', 'player_R0035_1744988361.png', 'player', '2025-04-18 14:59:21'),
(80, 'R0036', 'product_R0036_1744988371.png', 'product', '2025-04-18 14:59:31'),
(81, 'R0036', 'player_R0036_1744988371.png', 'player', '2025-04-18 14:59:31'),
(82, 'R0037', 'product_R0037_1744988380.png', 'product', '2025-04-18 14:59:40'),
(83, 'R0037', 'player_R0037_1744988380.png', 'player', '2025-04-18 14:59:40'),
(84, 'R0038', 'product_R0038_1744988397.png', 'product', '2025-04-18 14:59:57'),
(85, 'R0038', 'player_R0038_1744988397.png', 'player', '2025-04-18 14:59:57'),
(86, 'R0039', 'product_R0039_1744988409.png', 'product', '2025-04-18 15:00:09'),
(87, 'R0039', 'player_R0039_1744988409.png', 'player', '2025-04-18 15:00:09'),
(88, 'R0040', 'product_R0040_1744988419.png', 'product', '2025-04-18 15:00:19'),
(89, 'R0040', 'player_R0040_1744988419.png', 'player', '2025-04-18 15:00:19'),
(90, 'R0041', 'product_R0041_1744988436.png', 'product', '2025-04-18 15:00:36'),
(91, 'R0041', 'player_R0041_1744988436.png', 'player', '2025-04-18 15:00:36'),
(92, 'R0042', 'product_R0042_1744988454.png', 'product', '2025-04-18 15:00:54'),
(93, 'R0042', 'player_R0042_1744988454.png', 'player', '2025-04-18 15:00:54'),
(94, 'R0043', 'product_R0043_1744988464.png', 'product', '2025-04-18 15:01:04'),
(95, 'R0043', 'player_R0043_1744988464.png', 'player', '2025-04-18 15:01:04'),
(96, 'R0044', 'product_R0044_1744988482.png', 'product', '2025-04-18 15:01:22'),
(97, 'R0044', 'player_R0044_1744988482.png', 'player', '2025-04-18 15:01:22'),
(98, 'R0045', 'product_R0045_1744988493.png', 'product', '2025-04-18 15:01:33'),
(99, 'R0045', 'player_R0045_1744988493.png', 'player', '2025-04-18 15:01:33'),
(100, 'R0046', 'product_R0046_1744988552.png', 'product', '2025-04-18 15:02:32'),
(101, 'R0046', 'player_R0046_1744988552.png', 'player', '2025-04-18 15:02:32'),
(102, 'R0047', 'product_R0047_1744988561.png', 'product', '2025-04-18 15:02:41'),
(103, 'R0047', 'player_R0047_1744988561.png', 'player', '2025-04-18 15:02:41'),
(104, 'R0048', 'product_R0048_1744988570.png', 'product', '2025-04-18 15:02:50'),
(105, 'R0048', 'player_R0048_1744988570.png', 'player', '2025-04-18 15:02:50'),
(106, 'R0049', 'product_R0049_1744988581.png', 'product', '2025-04-18 15:03:01'),
(107, 'R0049', 'player_R0049_1744988581.png', 'player', '2025-04-18 15:03:01'),
(108, 'R0050', 'product_R0050_1744988590.png', 'product', '2025-04-18 15:03:10'),
(109, 'R0050', 'player_R0050_1744988590.png', 'player', '2025-04-18 15:03:10'),
(110, 'R0051', 'product_R0051_1744988622.png', 'product', '2025-04-18 15:03:42'),
(111, 'R0051', 'player_R0051_1744988622.png', 'player', '2025-04-18 15:03:42'),
(112, 'R0052', 'product_R0052_1744988630.png', 'product', '2025-04-18 15:03:50'),
(113, 'R0052', 'player_R0052_1744988630.png', 'player', '2025-04-18 15:03:50'),
(114, 'R0053', 'product_R0053_1744988640.png', 'product', '2025-04-18 15:04:00'),
(115, 'R0053', 'player_R0053_1744988640.png', 'player', '2025-04-18 15:04:00'),
(116, 'R0054', 'product_R0054_1744988661.png', 'product', '2025-04-18 15:04:21'),
(117, 'R0054', 'player_R0054_1744988661.png', 'player', '2025-04-18 15:04:21'),
(118, 'R0055', 'product_R0055_1744988670.png', 'product', '2025-04-18 15:04:30'),
(119, 'R0055', 'player_R0055_1744988670.png', 'player', '2025-04-18 15:04:30'),
(120, 'R0056', 'product_R0056_1744988679.png', 'product', '2025-04-18 15:04:39'),
(121, 'R0056', 'player_R0056_1744988679.png', 'player', '2025-04-18 15:04:39'),
(122, 'R0057', 'product_R0057_1744988695.png', 'product', '2025-04-18 15:04:55'),
(123, 'R0057', 'player_R0057_1744988695.png', 'player', '2025-04-18 15:04:55'),
(126, 'R0058', 'product_R0058_1744988708.png', 'product', '2025-04-18 15:05:08'),
(127, 'R0058', 'player_R0058_1744988708.png', 'player', '2025-04-18 15:05:08'),
(128, 'R0059', 'product_R0059_1744988718.png', 'product', '2025-04-18 15:05:18'),
(129, 'R0059', 'player_R0059_1744988718.png', 'player', '2025-04-18 15:05:18'),
(130, 'R0060', 'product_R0060_1744988731.png', 'product', '2025-04-18 15:05:31'),
(131, 'R0060', 'player_R0060_1744988731.png', 'player', '2025-04-18 15:05:31'),
(132, 'R0061', 'product_R0061_1744988759.png', 'product', '2025-04-18 15:05:59'),
(133, 'R0061', 'player_R0061_1744988759.png', 'player', '2025-04-18 15:05:59'),
(134, 'R0062', 'product_R0062_1744988771.png', 'product', '2025-04-18 15:06:11'),
(135, 'R0062', 'player_R0062_1744988771.png', 'player', '2025-04-18 15:06:11'),
(136, 'R0063', 'product_R0063_1744988788.png', 'product', '2025-04-18 15:06:28'),
(137, 'R0063', 'player_R0063_1744988788.png', 'player', '2025-04-18 15:06:28'),
(138, 'R0064', 'product_R0064_1744988807.png', 'product', '2025-04-18 15:06:47'),
(139, 'R0064', 'player_R0064_1744988807.png', 'player', '2025-04-18 15:06:47'),
(140, 'R0065', 'product_R0065_1744988826.png', 'product', '2025-04-18 15:07:06'),
(141, 'R0065', 'player_R0065_1744988826.png', 'player', '2025-04-18 15:07:06'),
(142, 'R0066', 'product_R0066_1744988837.png', 'product', '2025-04-18 15:07:17'),
(143, 'R0066', 'player_R0066_1744988837.png', 'player', '2025-04-18 15:07:17'),
(144, 'R0067', 'product_R0067_1744988849.png', 'product', '2025-04-18 15:07:29'),
(145, 'R0067', 'player_R0067_1744988849.png', 'player', '2025-04-18 15:07:29'),
(146, 'R0068', 'product_R0068_1744988860.png', 'product', '2025-04-18 15:07:40'),
(147, 'R0068', 'player_R0068_1744988860.png', 'player', '2025-04-18 15:07:40'),
(148, 'R0069', 'product_R0069_1744988888.png', 'product', '2025-04-18 15:08:08'),
(149, 'R0069', 'player_R0069_1744988888.png', 'player', '2025-04-18 15:08:08'),
(150, 'R0070', 'product_R0070_1744988900.png', 'product', '2025-04-18 15:08:20'),
(151, 'R0070', 'player_R0070_1744988900.png', 'player', '2025-04-18 15:08:20'),
(152, 'R0071', 'product_R0071_1744989027.png', 'product', '2025-04-18 15:10:27'),
(153, 'R0071', 'player_R0071_1744989027.png', 'player', '2025-04-18 15:10:27'),
(154, 'R0072', 'product_R0072_1744989038.png', 'product', '2025-04-18 15:10:38'),
(155, 'R0072', 'player_R0072_1744989038.png', 'player', '2025-04-18 15:10:38'),
(156, 'R0073', 'product_R0073_1744989052.png', 'product', '2025-04-18 15:10:52'),
(157, 'R0073', 'player_R0073_1744989052.png', 'player', '2025-04-18 15:10:52'),
(158, 'R0074', 'product_R0074_1744989069.png', 'product', '2025-04-18 15:11:09'),
(159, 'R0074', 'player_R0074_1744989069.png', 'player', '2025-04-18 15:11:09'),
(160, 'R0075', 'product_R0075_1744989081.png', 'product', '2025-04-18 15:11:21'),
(161, 'R0075', 'player_R0075_1744989081.png', 'player', '2025-04-18 15:11:21'),
(162, 'R0010', 'product_R0010_1744989229.png', 'product', '2025-04-18 15:13:49'),
(163, 'R0010', 'player_R0010_1744989229.png', 'player', '2025-04-18 15:13:49'),
(164, 'R0076', 'product_R0076_1744989343.png', 'product', '2025-04-18 15:15:43'),
(165, 'R0076', 'player_R0076_1744989343.png', 'player', '2025-04-18 15:15:43'),
(166, 'R0077', 'product_R0077_1744989357.png', 'product', '2025-04-18 15:15:57'),
(167, 'R0077', 'player_R0077_1744989357.png', 'player', '2025-04-18 15:15:57'),
(168, 'R0078', 'product_R0078_1744989376.png', 'product', '2025-04-18 15:16:16'),
(169, 'R0078', 'player_R0078_1744989376.png', 'player', '2025-04-18 15:16:16'),
(170, 'R0079', 'product_R0079_1744989396.png', 'product', '2025-04-18 15:16:36'),
(171, 'R0079', 'player_R0079_1744989396.png', 'player', '2025-04-18 15:16:36'),
(172, 'R0080', 'product_R0080_1744989414.png', 'product', '2025-04-18 15:16:54'),
(173, 'R0080', 'player_R0080_1744989414.png', 'player', '2025-04-18 15:16:54'),
(174, 'R0081', 'product_R0081_1744989446.png', 'product', '2025-04-18 15:17:26'),
(175, 'R0081', 'player_R0081_1744989446.png', 'player', '2025-04-18 15:17:26'),
(176, 'R0082', 'product_R0082_1744989458.png', 'product', '2025-04-18 15:17:38'),
(177, 'R0082', 'player_R0082_1744989458.png', 'player', '2025-04-18 15:17:38'),
(178, 'R0083', 'product_R0083_1744989475.png', 'product', '2025-04-18 15:17:55'),
(179, 'R0083', 'player_R0083_1744989475.png', 'player', '2025-04-18 15:17:55'),
(180, 'R0084', 'product_R0084_1744989489.png', 'product', '2025-04-18 15:18:09'),
(181, 'R0084', 'player_R0084_1744989489.png', 'player', '2025-04-18 15:18:09'),
(182, 'R0085', 'product_R0085_1744989506.png', 'product', '2025-04-18 15:18:26'),
(183, 'R0085', 'player_R0085_1744989506.png', 'player', '2025-04-18 15:18:26'),
(184, 'R0086', 'product_R0086_1744989521.png', 'product', '2025-04-18 15:18:41'),
(185, 'R0086', 'player_R0086_1744989521.png', 'player', '2025-04-18 15:18:41'),
(186, 'R0087', 'product_R0087_1744989531.png', 'product', '2025-04-18 15:18:51'),
(187, 'R0087', 'player_R0087_1744989531.png', 'player', '2025-04-18 15:18:51'),
(188, 'R0088', 'product_R0088_1744989542.png', 'product', '2025-04-18 15:19:02'),
(189, 'R0088', 'player_R0088_1744989542.png', 'player', '2025-04-18 15:19:02'),
(190, 'R0089', 'product_R0089_1744989558.png', 'product', '2025-04-18 15:19:18'),
(191, 'R0089', 'player_R0089_1744989558.png', 'player', '2025-04-18 15:19:18'),
(192, 'R0090', 'product_R0090_1744989572.png', 'product', '2025-04-18 15:19:32'),
(193, 'R0090', 'player_R0090_1744989572.png', 'player', '2025-04-18 15:19:32'),
(194, 'R0091', 'product_R0091_1744989582.png', 'product', '2025-04-18 15:19:42'),
(195, 'R0091', 'player_R0091_1744989582.png', 'player', '2025-04-18 15:19:42'),
(196, 'R0092', 'product_R0092_1744989595.png', 'product', '2025-04-18 15:19:55'),
(197, 'R0092', 'player_R0092_1744989595.png', 'player', '2025-04-18 15:19:55'),
(198, 'R0093', 'product_R0093_1744989611.png', 'product', '2025-04-18 15:20:11'),
(199, 'R0093', 'player_R0093_1744989611.png', 'player', '2025-04-18 15:20:11'),
(200, 'R0095', 'product_R0095_1744989648.png', 'product', '2025-04-18 15:20:48'),
(201, 'R0095', 'player_R0095_1744989648.png', 'player', '2025-04-18 15:20:48'),
(202, 'R0096', 'product_R0096_1744989669.png', 'product', '2025-04-18 15:21:09'),
(203, 'R0096', 'player_R0096_1744989669.png', 'player', '2025-04-18 15:21:09'),
(204, 'R0097', 'product_R0097_1744989678.png', 'product', '2025-04-18 15:21:18'),
(205, 'R0097', 'player_R0097_1744989678.png', 'player', '2025-04-18 15:21:18'),
(206, 'R0098', 'product_R0098_1744989688.png', 'product', '2025-04-18 15:21:28'),
(207, 'R0098', 'player_R0098_1744989688.png', 'player', '2025-04-18 15:21:28'),
(208, 'R0099', 'product_R0099_1744989696.png', 'product', '2025-04-18 15:21:36'),
(209, 'R0099', 'player_R0099_1744989696.png', 'player', '2025-04-18 15:21:36'),
(210, 'R0100', 'product_R0100_1744989707.png', 'product', '2025-04-18 15:21:47'),
(211, 'R0100', 'player_R0100_1744989707.png', 'player', '2025-04-18 15:21:47');

-- --------------------------------------------------------

--
-- Table structure for table `restock_history`
--

DROP TABLE IF EXISTS `restock_history`;
CREATE TABLE `restock_history` (
  `restockID` int(11) NOT NULL,
  `productID` varchar(20) NOT NULL,
  `sizeID` varchar(20) NOT NULL,
  `restock_quantity` int(11) NOT NULL,
  `restocked_by` varchar(250) DEFAULT NULL,
  `restock_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `savedaddress`
--

DROP TABLE IF EXISTS `savedaddress`;
CREATE TABLE `savedaddress` (
  `userID` int(11) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phoneNo` varchar(15) NOT NULL,
  `name` varchar(40) NOT NULL,
  `defaultAdd` tinyint(1) NOT NULL DEFAULT 0,
  `addressIndex` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `savedaddress`
--

INSERT INTO `savedaddress` (`userID`, `address`, `phoneNo`, `name`, `defaultAdd`, `addressIndex`) VALUES
(1, 'Straits Court, JALAN Ujong pasir, 75050, Melaka', '60126289399', 'MR lolipop', 1, 7);

-- --------------------------------------------------------

--
-- Table structure for table `series`
--

DROP TABLE IF EXISTS `series`;
CREATE TABLE `series` (
  `seriesID` varchar(3) NOT NULL,
  `seriesName` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `series`
--

INSERT INTO `series` (`seriesID`, `seriesName`) VALUES
('AS', 'AeroSharp'),
('PHM', 'Phantom'),
('SHD', 'Shadow'),
('TSM', 'TurboSmash'),
('TST', 'ThunderStrike');

-- --------------------------------------------------------

--
-- Table structure for table `token`
--

DROP TABLE IF EXISTS `token`;
CREATE TABLE `token` (
  `id` int(11) NOT NULL,
  `type` enum('verify-email','change-password','remember-user') NOT NULL,
  `selector` char(12) DEFAULT NULL COMMENT 'for remember-user tokens',
  `hashedValidator` char(64) DEFAULT NULL COMMENT 'for remember-user tokens. Hashed with SHA256\r\n',
  `expire` datetime NOT NULL,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `passwordHash` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `emailVerified` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'tinyint(1) is the same as boolean. 0 is false, 1 is true.',
  `phoneNo` varchar(15) DEFAULT NULL,
  `gender` enum('F','M','R') NOT NULL DEFAULT 'R' COMMENT 'F: Female. \r\nM: Male.\r\nR: Rather not say',
  `profilePic` varchar(255) DEFAULT NULL,
  `bio` varchar(1000) DEFAULT NULL,
  `memberStatus` enum('Active','Inactive','Blocked') NOT NULL COMMENT 'Inactive means not registered as a member (as in a customer who enjoys certain privileges).',
  `isDeleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'tinyint(1) is the same as boolean. 0 is false, 1 is true.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `passwordHash`, `address`, `birthdate`, `email`, `emailVerified`, `phoneNo`, `gender`, `profilePic`, `bio`, `memberStatus`, `isDeleted`) VALUES
(1, 'cookie', '$2y$10$y9w5iLGDpKgYyStjoM1.G.sWRoSTKVHIZ/Tk125N7CIVdBZ/iITuC', NULL, NULL, 'cookie@mail.com', 0, '012-3456789', 'R', NULL, 'I love cookies, as you may have already guessed', 'Inactive', 0),
(2, 'icecream', '$2y$10$HN1VCP3xMBQkkD4fsxUMUe4Ri/ujjDaoJ9u1vZTdibF8yyXjfQ3LG', NULL, NULL, 'icecream@mail.com', 0, '012-9876543', 'R', NULL, 'I love ice cream!', 'Inactive', 0),
(4, 'cookie2', '$2y$10$j3VTdYyGhsqKo8f0Fn1NMe1lt2Kr9fLKJLEW.AXALN6J6EVqCTpFy', NULL, NULL, 'jasonlhtown@gmail.com', 0, NULL, 'R', NULL, NULL, 'Inactive', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

DROP TABLE IF EXISTS `vouchers`;
CREATE TABLE `vouchers` (
  `voucherCode` varchar(15) NOT NULL,
  `amount` int(3) NOT NULL,
  `issuedBy` varchar(10) NOT NULL,
  `allowedUsage` int(10) NOT NULL,
  `totalUsage` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucherCode`, `amount`, `issuedBy`, `allowedUsage`, `totalUsage`) VALUES
('TEST123', 30, 'A003', 10, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blockeduser`
--
ALTER TABLE `blockeduser`
  ADD PRIMARY KEY (`blockedUserID`);

--
-- Indexes for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD PRIMARY KEY (`userID`,`productID`,`sizeID`),
  ADD KEY `productID` (`productID`,`sizeID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`orderId`,`productId`,`gripSize`),
  ADD KEY `productId` (`productId`),
  ADD KEY `order_items_ibfk_2` (`productId`,`gripSize`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `seriesID` (`seriesID`);

--
-- Indexes for table `productstock`
--
ALTER TABLE `productstock`
  ADD PRIMARY KEY (`productID`,`sizeID`),
  ADD UNIQUE KEY `qr_token` (`qr_token`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD PRIMARY KEY (`restockID`),
  ADD KEY `productID` (`productID`,`sizeID`);

--
-- Indexes for table `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD PRIMARY KEY (`addressIndex`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`seriesID`);

--
-- Indexes for table `token`
--
ALTER TABLE `token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID-fk` (`userID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email_unique` (`email`),
  ADD UNIQUE KEY `username_unique` (`username`),
  ADD KEY `email` (`email`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucherCode`),
  ADD KEY `issuedBy` (`issuedBy`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12355;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=212;

--
-- AUTO_INCREMENT for table `restock_history`
--
ALTER TABLE `restock_history`
  MODIFY `restockID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `savedaddress`
--
ALTER TABLE `savedaddress`
  MODIFY `addressIndex` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `token`
--
ALTER TABLE `token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cartitem`
--
ALTER TABLE `cartitem`
  ADD CONSTRAINT `cartitem_ibfk_1` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productstock` (`productID`, `sizeID`),
  ADD CONSTRAINT `userid_fk` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`orderId`) REFERENCES `orders` (`orderId`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`productId`,`gripSize`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`seriesID`) REFERENCES `series` (`seriesID`);

--
-- Constraints for table `productstock`
--
ALTER TABLE `productstock`
  ADD CONSTRAINT `productStock_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`) ON DELETE CASCADE;

--
-- Constraints for table `restock_history`
--
ALTER TABLE `restock_history`
  ADD CONSTRAINT `restock_history_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `restock_history_ibfk_2` FOREIGN KEY (`productID`,`sizeID`) REFERENCES `productstock` (`productID`, `sizeID`);

--
-- Constraints for table `savedaddress`
--
ALTER TABLE `savedaddress`
  ADD CONSTRAINT `savedaddress_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `token`
--
ALTER TABLE `token`
  ADD CONSTRAINT `userID-fk` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE CASCADE;

--
-- Constraints for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD CONSTRAINT `vouchers_ibfk_1` FOREIGN KEY (`issuedBy`) REFERENCES `admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
