<?php

namespace App\Services\Astrology;

/**
 * Classical 12-Bhava Interpretation Dictionary
 * Sourced from Chapter 17 of Vedanga Jyothisham (pp. 99–143), Brihat Parasara Hora Sastra,
 * and traditional Kerala Hora canons.
 *
 * Provides complete, non-generic, chart-specific interpretations for:
 * 1. 12 Lagna Rasis (Physical traits, psychology, milestone ages, Drekkanas)
 * 2. 144 Bhava Lord Placements (L1_H1 to L12_H12)
 * 3. 120 Planet-in-House Placements (Su, Mo, Ma, Me, Ju, Ve, Sa, Ra, Ke, Md across 12 houses)
 * 4. Special & Direct Planetary Aspects (Drishti Phalam)
 */
class BhavaInterpretationDictionary
{
    /**
     * 12 Lagna Profiles (Physical appearance, psychological traits, key ages, 3 Drekkanas)
     */
    public const LAGNA_PROFILES = [
        1 => [
            'name_ml' => 'മേടം (Mesha)',
            'name_en' => 'Aries (Mesha)',
            'ruler' => 'Ma',
            'element' => 'Fire (തേജസ്സ്)',
            'traits_ml' => 'ധൈര്യശാലിയും കാര്യപ്രാപ്തിയുമുള്ള പ്രകൃതം. നേതൃത്വഗുണവും വേഗത്തിൽ തീരുമാനങ്ങൾ എടുക്കാനുള്ള കഴിവുമുണ്ട്. മുൻകോപം, ഉത്സാഹം, സ്വതന്ത്ര ചിന്താഗതി എന്നിവ മുഖമുദ്രയാണ്. പ്രതിബന്ധങ്ങളെ ധീരമായി നേരിടും.',
            'traits_en' => 'Dynamic, bold, and pioneering. Possesses natural leadership and rapid decision-making ability. Exhibits occasional impulsiveness, high ambition, and fiercely independent character. Overcomes obstacles with direct courage.',
            'physical_ml' => 'ഇടത്തരം ഉയരം, ആകർഷകമായ മുഖഭാവം, ചടുലമായ നടത്തം, തുറന്ന നോട്ടം, ചുറുചുറുക്കുള്ള ശരീരം.',
            'physical_en' => 'Medium stature, sharp facial contours, swift gait, expressive gaze, and energetic physical constitution.',
            'milestone_ages' => '16, 21, 28, 34, 42, 56',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): കുജന്റെ സ്വാധീനം - അസാധാരണ സാഹസികത, പോരാട്ടവീര്യം, സ്വപ്രയത്നത്താൽ ഉന്നതി.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): രവിയുടെ സ്വാധീനം - ആത്മാഭിമാനം, ഉന്നത ചിന്ത, ഭരണസാമർത്ഥ്യം, സൽക്കീർത്തി.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): വ്യാഴത്തിന്റെ സ്വാധീനം - ധർമ്മനിഷ്ഠ, ഉദാരമനസ്കത, ആത്മീയ താത്പര്യം, കുടുംബസ്നേഹം.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Mars ruler - High courage, combative spirit, and self-made ascendancy.',
                2 => '2nd Drekkana (10°-20°): Sun ruler - Strong self-respect, elevated ideals, administrative capability, and noble renown.',
                3 => '3rd Drekkana (20°-30°): Jupiter ruler - Righteous conduct, generous disposition, spiritual inclination, and family devotion.',
            ],
        ],
        2 => [
            'name_ml' => 'ഇടവം (Vrishabha)',
            'name_en' => 'Taurus (Vrishabha)',
            'ruler' => 'Ve',
            'element' => 'Earth (പൃഥ്വി)',
            'traits_ml' => 'ശാന്തത, ക്ഷമ, ദൃഢനിശ്ചയം എന്നിവ നിറഞ്ഞ വ്യക്തിത്വം. സംഗീതം, കല, സൗന്ദര്യബോധം എന്നിവയിൽ അതീവ താത്പര്യം. സാമ്പത്തിക ഭദ്രതയ്ക്കും കുടുംബ സുഖത്തിനും മുൻഗണന നൽകുന്നു.',
            'traits_en' => 'Patient, steadfast, and grounded personality. Deep appreciation for arts, music, elegance, and beauty. Prioritizes financial security, domestic contentment, and reliable long-term relationships.',
            'physical_ml' => 'സുന്ദരമായ കണ്ണുകൾ, ഇടത്തരം ശരീരം, പ്രസന്നമായ മുഖം, ആകർഷകമായ ശബ്ദം.',
            'physical_en' => 'Lustrous eyes, sturdy well-proportioned body, pleasant countenance, and resonant voice.',
            'milestone_ages' => '18, 24, 32, 36, 44, 52',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ശുക്രന്റെ സ്വാധീനം - കലാവാസന, സൗന്ദര്യാസ്വാദനം, ലളിതമായ ജീവിതരീതി.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ബുധന്റെ സ്വാധീനം - ബുദ്ധിസാമർത്ഥ്യം, ബിസിനസ്സ് കാഴ്ചപ്പാട്, വാക്ചാതുര്യം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ശനിയുടെ സ്വാധീനം - കഠിനാധ്വാനം, മിതവ്യയം, യാഥാർത്ഥ്യബോധത്തോടെയുള്ള വളർച്ച.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Venus ruler - Artistic flair, aesthetic refinement, and graceful conduct.',
                2 => '2nd Drekkana (10°-20°): Mercury ruler - Intellect, sharp business acumen, and persuasive speech.',
                3 => '3rd Drekkana (20°-30°): Saturn ruler - Persistent labor, prudent resource stewardship, and pragmatic development.',
            ],
        ],
        3 => [
            'name_ml' => 'മിഥുനം (Mithuna)',
            'name_en' => 'Gemini (Mithuna)',
            'ruler' => 'Me',
            'element' => 'Air (വായു)',
            'traits_ml' => 'വിദ്യാവിനോദങ്ങളിൽ തല്പരൻ, ആശയവിനിമയ മികവ്, രസികത്വം, പുതിയ കാര്യങ്ങൾ വേഗത്തിൽ ഗ്രഹിക്കാനുള്ള ശേഷി. ബഹുമുഖ പ്രതിഭയും ചടുലമായ ബുദ്ധിയും.',
            'traits_en' => 'Intellectually versatile, communicative, witty, and rapid in absorbing multifaceted disciplines. Enjoys scholarly discourses and diverse social interactions.',
            'physical_ml' => 'ഉയരമുള്ള ശരീരം, നീണ്ട വിരലുകൾ, ചുറുചുറുക്കുള്ള ചലനങ്ങൾ, ബുദ്ധികൂർമ്മതയുള്ള നോട്ടം.',
            'physical_en' => 'Tall slender build, long fingers, agile body language, and quick inquiring eyes.',
            'milestone_ages' => '15, 22, 27, 33, 41, 54',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ബുധന്റെ സ്വാധീനം - സാഹിത്യഭിരുചി, ഗണിത സാമർത്ഥ്യം, വാക്സാമർത്ഥ്യം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ശുക്രന്റെ സ്വാധീനം - സർഗ്ഗാത്മകത, ആതിഥ്യമര്യാദ, ജനപ്രിയത.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ശനിയുടെ സ്വാധീനം - ഗഹനമായ ചിന്ത, ഗവേഷണ താല്പര്യം, ക്രമാനുഗതമായ പുരോഗതി.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Mercury ruler - Literary skills, analytical acumen, and sharp communication.',
                2 => '2nd Drekkana (10°-20°): Venus ruler - Creative flair, cordial hospitality, and broad popularity.',
                3 => '3rd Drekkana (20°-30°): Saturn ruler - Analytical depth, research capability, and steady gradual growth.',
            ],
        ],
        4 => [
            'name_ml' => 'കർക്കിടകം (Karkidaka)',
            'name_en' => 'Cancer (Karkidaka)',
            'ruler' => 'Mo',
            'element' => 'Water (ജലം)',
            'traits_ml' => 'വികാരഭരിതമായ മനസ്സ്, മാതൃസ്നേഹം, സഹാനുഭൂതി, ആതിഥ്യമര്യാദ. കുടുംബത്തോടും നാടിനോടും അതീവ കൂറ്. മാനസിക നിലയിൽ ചന്ദ്രന്റെ വൃദ്ധിക്ഷയങ്ങൾക്കനുസരിച്ച് മാറ്റങ്ങൾ അനുഭവപ്പെടാം.',
            'traits_en' => 'Intuitive, deeply nurturing, empathetic, and hospitable. Fiercely devoted to family and ancestral heritage. Moods may reflect lunar phases, balanced by profound emotional resilience.',
            'physical_ml' => 'വൃത്താകൃതിയിലുള്ള മുഖം, കാരുണ്യം തുളുമ്പുന്ന കണ്ണുകൾ, സാത്വികമായ സൗന്ദര്യം.',
            'physical_en' => 'Round expressive face, compassionate gaze, soft features, and gentle presence.',
            'milestone_ages' => '17, 24, 31, 38, 45, 53',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ചന്ദ്രന്റെ സ്വാധീനം - ദയ, കവിഹൃദയം, ഭാവനാസമ്പന്നത.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): കുജന്റെ സ്വാധീനം - പ്രതികരണശേഷി, ഉന്മേഷം, കുടുംബസംരക്ഷണത്വര.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): വ്യാഴത്തിന്റെ സ്വാധീനം - ആത്മീയജ്ഞാനം, പരോപകാര താല്പര്യം, ബഹുമാന്യത.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Moon ruler - Compassion, poetic sensibilities, and fertile imagination.',
                2 => '2nd Drekkana (10°-20°): Mars ruler - Protective instinct, dynamic energy, and devotion to defending hearth.',
                3 => '3rd Drekkana (20°-30°): Jupiter ruler - Spiritual nobility, benevolent philanthropy, and respected community standing.',
            ],
        ],
        5 => [
            'name_ml' => 'ചിങ്ങം (Chingam / Leo)',
            'name_en' => 'Leo (Simha)',
            'ruler' => 'Su',
            'element' => 'Fire (തേജസ്സ്)',
            'traits_ml' => 'ഗംഭീരമായ പെരുമാറ്റം, ആജ്ഞാശക്തി, ആത്മാഭിമാനം, ഉദാരമനസ്സ്. നീതിപൂർവ്വമായ നിലപാടുകൾ, സ്വാഭിമാനം ആരുടെ മുന്നിലും അടിയറവെക്കാത്ത പ്രകൃതം. ഭക്ഷണപ്രിയം, നേതൃസ്ഥാനങ്ങളിൽ ശോഭിക്കാനുള്ള നൈസർഗ്ഗിക സിദ്ധി.',
            'traits_en' => 'Regal demeanor, natural authority, strong sense of honor, and generous heart. Values justice, commands innate respect, and preserves self-esteem without compromise. Natural propensity for leadership and governance.',
            'physical_ml' => 'വിശാലമായ നെറ്റിത്തടം, ദൃഢഗാത്രമായ ശരീരം, ഗാംഭീര്യമുള്ള നോട്ടം, ആജ്ഞാഭാവമുള്ള നടത്തം.',
            'physical_en' => 'Broad forehead, majestic carriage, firm physique, penetrating gaze, and authoritative presence.',
            'milestone_ages' => '19, 26, 33, 40, 48, 55',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): രവിയുടെ സ്വാധീനം - ശുദ്ധമായ സാത്വിക തേജസ്സ്, രാജകീയ നിലപാട്, ഉന്നത പദവി.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): വ്യാഴത്തിന്റെ സ്വാധീനം - വിജ്ഞാന സമ്പാദനം, ഉപദേശക യോഗ്യത, ധർമ്മനിഷ്ഠ.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): കുജന്റെ സ്വാധീനം - അസാമാന്യ ധൈര്യം, ഭരണസാമർത്ഥ്യം, ശത്രുജയം.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Sun ruler - Pure solar radiance, stately principles, and early executive command.',
                2 => '2nd Drekkana (10°-20°): Jupiter ruler - Philosophical depth, advisory counsel, and righteous living.',
                3 => '3rd Drekkana (20°-30°): Mars ruler - Fearless bravery, martial stamina, and definitive victory over opposition.',
            ],
        ],
        6 => [
            'name_ml' => 'കന്നി (Kanni / Virgo)',
            'name_en' => 'Virgo (Kanya)',
            'ruler' => 'Me',
            'element' => 'Earth (പൃഥ്വി)',
            'traits_ml' => 'സൂക്ഷ്മനിരീക്ഷണം, ചിട്ടയായ കാര്യനിർവ്വഹണം, ബുദ്ധിസാമർത്ഥ്യം, പക്വത. കണക്കുകൾ, അപഗ്രഥനം, വൈദ്യം, സാഹിത്യം എന്നിവയിൽ വിരുതൻ. കാര്യങ്ങൾ പൂർണ്ണതയോടെ ചെയ്യാൻ ആഗ്രഹിക്കുന്നു.',
            'traits_en' => 'Analytical, methodical, intellectually meticulous, and practical. Excellence in commerce, medicine, writing, and systemic problem-solving. Perfectionist mindset with keen eye for detail.',
            'physical_ml' => 'മധ്യരൂപം, പ്രസന്നമായ ഭാവം, മിതഭാഷിത്വം, ലളിതമായ വേഷഭൂഷാദികൾ.',
            'physical_en' => 'Well-proportioned, neat appearance, articulate subtle expression, and dignified simplicity.',
            'milestone_ages' => '18, 23, 30, 37, 45, 52',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ബുധന്റെ സ്വാധീനം - കണക്കുകൂട്ടലുകളിലെ കൃത്യത, ലേഖന സാമർത്ഥ്യം, ബുദ്ധിവികാസം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ശനിയുടെ സ്വാധീനം - അക്ഷീണപരിശ്രമം, കാര്യക്ഷമത, ഗൗരവമുള്ള സമീപനം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ശുക്രന്റെ സ്വാധീനം - സുകുമാര കലകളിലെ താല്പര്യം, ഭംഗി, സാമൂഹിക മര്യാദ.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Mercury ruler - Mathematical precision, editorial prowess, and logical clarity.',
                2 => '2nd Drekkana (10°-20°): Saturn ruler - Patient endurance, operational efficiency, and serious demeanor.',
                3 => '3rd Drekkana (20°-30°): Venus ruler - Aesthetic taste, polite charm, and refined social diplomacy.',
            ],
        ],
        7 => [
            'name_ml' => 'തുലാം (Thulam / Libra)',
            'name_en' => 'Libra (Thula)',
            'ruler' => 'Ve',
            'element' => 'Air (വായു)',
            'traits_ml' => 'നീതിബോധം, സന്തുലിതാവസ്ഥ, മര്യാദയുള്ള പെരുമാറ്റം, ജനസ്വാധീനം. സമാധാനപ്രിയൻ, പക്ഷപാതമില്ലാത്ത തീർപ്പുകൾ കല്പിക്കാനുള്ള ശേഷി. സൗന്ദര്യവും കലകളും ആസ്വദിക്കുന്ന പ്രകൃതം.',
            'traits_en' => 'Diplomatic, fair-minded, charming, and justice-oriented. Gifted arbitrator with innate balanced perception. Passionate about art, refined culture, harmony, and elegant partnerships.',
            'physical_ml' => 'സുന്ദരമായ ശരീരപ്രകൃതി, ചിരിക്കുന്ന മുഖം, പ്രസന്നമായ കണ്ണുകൾ, ആകർഷകമായ നടത്തം.',
            'physical_en' => 'Graceful symmetrical features, smiling pleasant countenance, bright eyes, and poised carriage.',
            'milestone_ages' => '20, 25, 32, 39, 46, 54',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ശുക്രന്റെ സ്വാധീനം - ആഭരണ-വസ്ത്രാദി താല്പര്യം, സൗമ്യത, മാധുര്യമുള്ള സംസാരം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ശനിയുടെ സ്വാധീനം - നീതിപാലനം, പക്വമായ വിധിതീർപ്പുകൾ, ക്ഷമാശീലം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ബുധന്റെ സ്വാധീനം - വ്യാപാര വൈദഗ്ദ്ധ്യം, വാണിജ്യ നേട്ടങ്ങൾ, സാഹിത്യാഭിരുചി.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Venus ruler - Refined taste in clothing and luxuries, gentle manners, and sweet voice.',
                2 => '2nd Drekkana (10°-20°): Saturn ruler - Judicious equity, seasoned discretion, and unwavering patience.',
                3 => '3rd Drekkana (20°-30°): Mercury ruler - Commercial dexterity, lucrative enterprise, and eloquence.',
            ],
        ],
        8 => [
            'name_ml' => 'വൃശ്ചികം (Vrischikam / Scorpio)',
            'name_en' => 'Scorpio (Vrischika)',
            'ruler' => 'Ma',
            'element' => 'Water (ജലം)',
            'traits_ml' => 'തീവ്രമായ ആന്തരികശക്തി, മനക്കരുത്ത്, രഹസ്യസ്വഭാവം, ഗവേഷണ താല്പര്യം. തോൽവി സമ്മതിക്കാത്ത മനോഭാവം. ശത്രുക്കളെ തന്ത്രപൂർവ്വം പ്രതിരോധിക്കും. ആത്മീയതയിലും ശാസ്ത്രരഹസ്യങ്ങളിലും അതിയായ താല്പര്യം.',
            'traits_en' => 'Intense inner fortitude, impenetrable willpower, enigmatic depth, and investigative genius. Never accepts defeat easily. Possesses sharp intuition, occult acumen, and resolute loyalty to allies.',
            'physical_ml' => 'തീക്ഷ്ണമായ നോട്ടം, ഇടത്തരം ഉയരം, ഉറച്ച ശരീരം, ആത്മവിശ്വാസം പ്രകടമാകുന്ന ഭാവം.',
            'physical_en' => 'Piercing magnetic gaze, robust medium build, firm carriage, and calm intense presence.',
            'milestone_ages' => '21, 28, 35, 42, 49, 57',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): കുജന്റെ സ്വാധീനം - ഉശിരൻ മനസ്സ്, പ്രതിരോധ ശേഷി, ധീരമായ പോരാട്ടവീര്യം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): വ്യാഴത്തിന്റെ സ്വാധീനം - ആത്മീയ ചിന്ത, ധർമ്മനിഷ്ഠ, വിവേകം നിറഞ്ഞ ഉപദേശങ്ങൾ.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ചന്ദ്രന്റെ സ്വാധീനം - സൂക്ഷ്മമായ അന്തർജ്ഞാനം, ഭാവനാശക്തി, കുടുംബസ്നേഹം.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Mars ruler - Incisive courage, combative grit, and unwavering stamina.',
                2 => '2nd Drekkana (10°-20°): Jupiter ruler - Philosophical inclination, ethical rigor, and sagacious wisdom.',
                3 => '3rd Drekkana (20°-30°): Moon ruler - Deep emotional intuition, imaginative capability, and domestic care.',
            ],
        ],
        9 => [
            'name_ml' => 'ധനു (Dhanu / Sagittarius)',
            'name_en' => 'Sagittarius (Dhanu)',
            'ruler' => 'Ju',
            'element' => 'Fire (തേജസ്സ്)',
            'traits_ml' => 'ഉദാരമതി, സത്യസന്ധൻ, ഈശ്വരവിശ്വാസം, ഉയർന്ന ആദർശങ്ങൾ. നിയമം, നീതി, ഉപദേശം, പ്രഭാഷണം എന്നിവയിൽ നൈപുണ്യം. ദീർഘദൃഷ്ടിയും ശുഭാപ്തിവിശ്വാസവും നിറഞ്ഞ ജീവിതസമീപനം.',
            'traits_en' => 'Magnanimous, philosophical, candid, and upright. High devotion to truth, jurisprudence, higher learning, and mentor roles. Inspiring optimism with far-reaching vision.',
            'physical_ml' => 'നീളമുള്ള ശരീരം, വിടർന്ന നെഞ്ച്, പ്രസന്നമായ മുഖം, തന്റേടമുള്ള ചലനങ്ങൾ.',
            'physical_en' => 'Tall stately stature, open chest, noble expression, and self-assured purposeful stride.',
            'milestone_ages' => '16, 22, 29, 36, 44, 53',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): വ്യാഴത്തിന്റെ സ്വാധീനം - ഉന്നതമായ ധർമ്മചിന്ത, ആത്മീയ ഔന്നത്യം, ബഹുമാന്യത.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): കുജന്റെ സ്വാധീനം - ധീരത, കർമ്മോത്സാഹം, കാര്യവിജയം, നിയമപാലനം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): രവിയുടെ സ്വാധീനം - ഭരണനൈപുണ്യം, നേതൃത്വം, പ്രശസ്തി, ജനസമ്മിതി.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Jupiter ruler - Lofty righteousness, spiritual dignity, and revered societal stature.',
                2 => '2nd Drekkana (10°-20°): Mars ruler - Enterprising courage, executive dynamism, and championing justice.',
                3 => '3rd Drekkana (20°-30°): Sun ruler - Administrative mastery, command authority, and enduring repute.',
            ],
        ],
        10 => [
            'name_ml' => 'മകരം (Makaram / Capricorn)',
            'name_en' => 'Capricorn (Makara)',
            'ruler' => 'Sa',
            'element' => 'Earth (പൃഥ്വി)',
            'traits_ml' => 'കഠിനാധ്വാനി, അച്ചടക്കമുള്ള വ്യക്തിത്വം, യാഥാർത്ഥ്യബോധം, ക്ഷമാശീലം. പടിപടിയായി കഠിനപരിശ്രമത്തിലൂടെ ജീവിതവിജയം കൈവരിക്കുന്നു. ഭരണത്തിലും സംഘടനാരംഗത്തും ശാശ്വതമായ നേട്ടങ്ങൾ.',
            'traits_en' => 'Disciplined, tenacious, pragmatic, and patient builder. Achieves lasting success through incremental, steady labor. Excels in long-range administration, governance, and organizational hierarchy.',
            'physical_ml' => 'മെലിഞ്ഞ ശരീരം, ഗൗരവമുള്ള മുഖഭാവം, കഠിനാധ്വാനം പ്രതിഫലിക്കുന്ന കണ്ണുകൾ.',
            'physical_en' => 'Lean wiry build, dignified stoic expression, and focused, resolute gaze.',
            'milestone_ages' => '21, 28, 35, 42, 50, 58',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ശനിയുടെ സ്വാധീനം - കർക്കശമായ അച്ചടക്കം, കഠിനപരിശ്രമം, സുസ്ഥിരമായ വിജയം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ശുക്രന്റെ സ്വാധീനം - സാമ്പത്തിക ഭദ്രത, കലകളിൽ ആദരവ്, കുടുംബസുഖം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ബുധന്റെ സ്വാധീനം - പ്രായോഗിക ബുദ്ധി, സാമ്പത്തിക കാര്യനിർവ്വഹണം, വാണിജ്യലാഭം.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Saturn ruler - Rigorous discipline, steadfast industry, and rock-solid endurance.',
                2 => '2nd Drekkana (10°-20°): Venus ruler - Material stability, appreciation of quality crafts, and domestic ease.',
                3 => '3rd Drekkana (20°-30°): Mercury ruler - Prudent pragmatism, sharp accounting, and commercial profit.',
            ],
        ],
        11 => [
            'name_ml' => 'കുംഭം (Kumbham / Aquarius)',
            'name_en' => 'Aquarius (Kumbha)',
            'ruler' => 'Sa',
            'element' => 'Air (വായു)',
            'traits_ml' => 'മൗലിക ചിന്തകൻ, മാനവികതാവാദി, ദീർഘവീക്ഷണം, പരോപകാരതാല്പര്യം. പരമ്പരാഗത ചട്ടക്കൂടുകൾക്കപ്പുറം ചിന്തിക്കാനുള്ള കഴിവ്. ശാസ്ത്രം, സാങ്കേതികവിദ്യ, സാമൂഹിക പരിഷ്കരണം എന്നിവയിൽ അതീവ താത്പര്യം.',
            'traits_en' => 'Visionary thinker, humanitarian, progressive, and deeply philosophical. Thinks beyond traditional boundaries. Passionate about innovation, egalitarian principles, and societal improvement.',
            'physical_ml' => 'ഇടത്തരം ഉയരം, പ്രസന്നമായ ഭാവം, ബുദ്ധിസാമർത്ഥ്യം തുളുമ്പുന്ന കണ്ണുകൾ, സൗമ്യമായ സംസാരം.',
            'physical_en' => 'Medium stature, thoughtful visage, observant eyes, and candid, courteous demeanor.',
            'milestone_ages' => '20, 25, 33, 41, 49, 56',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): ശനിയുടെ സ്വാധീനം - ഗഹനമായ തത്ത്വചിന്ത, നിഷ്പക്ഷത, ജനക്ഷേമ താല്പര്യം.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ബുധന്റെ സ്വാധീനം - ശാസ്ത്രീയ നിരീക്ഷണം, സാങ്കേതിക വൈദഗ്ദ്ധ്യം, ബുദ്ധിപരമായ മുന്നേറ്റം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): ശുക്രന്റെ സ്വാധീനം - വിശാല സൗഹൃദങ്ങൾ, കലകളിൽ അഭിരുചി, സൗമ്യമായ ജീവിതശൈലി.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Saturn ruler - Deep philosophical introspection, objectivity, and community welfare.',
                2 => '2nd Drekkana (10°-20°): Mercury ruler - Scientific clarity, technical skill, and innovative intellectual ventures.',
                3 => '3rd Drekkana (20°-30°): Venus ruler - Broad social camaraderie, artistic appreciation, and refined lifestyle.',
            ],
        ],
        12 => [
            'name_ml' => 'മീനം (Meenam / Pisces)',
            'name_en' => 'Pisces (Meena)',
            'ruler' => 'Ju',
            'element' => 'Water (ജലം)',
            'traits_ml' => 'സാത്വിക പ്രകൃതം, ആത്മീയ താല്പര്യം, ദയ, വിട്ടുവീഴ്ചാ മനോഭാവം, ഭാവനാസമ്പന്നത. ഈശ്വരഭക്തിയും പരോപകാര ചിന്തയും ജീവിതത്തിന്റെ മുഖമുദ്രയാണ്. കല, സാഹിത്യം, പ്രാർത്ഥന എന്നിവയിൽ സമാധാനം കണ്ടെത്തുന്നു.',
            'traits_en' => 'Intuitive, spiritually attuned, empathetic, imaginative, and gentle. Finds profound solace in divine devotion, philanthropy, poetry, and contemplative pursuits. Natural inclination towards higher consciousness.',
            'physical_ml' => 'സ്നിഗ്ദ്ധമായ ശരീരം, പ്രസന്നവും ഭക്തിനിർഭരവുമായ കണ്ണുകൾ, ശാന്തമായ ഭാവം.',
            'physical_en' => 'Gentle graceful build, luminous tranquil eyes, and serene contemplative expression.',
            'milestone_ages' => '17, 24, 30, 37, 45, 52',
            'drekkanas_ml' => [
                1 => 'ഒന്നാം ദ്രേക്കാണം (0°-10°): വ്യാഴത്തിന്റെ സ്വാധീനം - ഉന്നതമായ ആത്മീയത, പരമസാത്വികത, വിജ്ഞാനാനുഭൂതി.',
                2 => 'രണ്ടാം ദ്രേക്കാണം (10°-20°): ചന്ദ്രന്റെ സ്വാധീനം - ആർദ്രമായ മനസ്സ്, സുകുമാര കലകളിലെ വൈഭവം, ജലയാത്രാ താല്പര്യം.',
                3 => 'മൂന്നാം ദ്രേക്കാണം (20°-30°): കുജന്റെ സ്വാധീനം - ധർമ്മസംരക്ഷണാഗ്രഹം, തപോനിഷ്ഠ, ഉന്മേഷം നിറഞ്ഞ സാത്വിക കർമ്മങ്ങൾ.',
            ],
            'drekkanas_en' => [
                1 => '1st Drekkana (0°-10°): Jupiter ruler - Sublime spiritual wisdom, pure sattvic poise, and noble virtue.',
                2 => '2nd Drekkana (10°-20°): Moon ruler - Deeply tender heart, fine poetic gifts, and affinity for water or overseas travels.',
                3 => '3rd Drekkana (20°-30°): Mars ruler - Devotion to upholding dharma, disciplined spiritual practice, and noble courage.',
            ],
        ],
    ];

    /**
     * Get 144 Bhava Lord Placements (L1_H1 to L12_H12)
     */
    public static function getBhavaLordInterpretation(int $lordHouse, int $placedHouse, string $lang = 'ml'): string
    {
        $key = "L{$lordHouse}_H{$placedHouse}";
        $entry = self::BHAVA_LORD_PLACEMENTS[$key] ?? null;

        if ($entry && isset($entry[$lang])) {
            return $entry[$lang];
        }

        if ($entry && isset($entry['en'])) {
            return $entry['en'];
        }

        // Contextual dynamic fallback if specific key is unavailable
        $ord = [1=>'ഒന്നാം', 2=>'രണ്ടാം', 3=>'മൂന്നാം', 4=>'നാലാം', 5=>'അഞ്ചാം', 6=>'ആറാം', 7=>'ഏഴാം', 8=>'എട്ടാം', 9=>'ഒമ്പതാം', 10=>'പത്താം', 11=>'പതിനൊന്നാം', 12=>'പന്ത്രണ്ടാം'];
        $hName = [1=>'തനു', 2=>'ധന', 3=>'സഹജ', 4=>'സുഖ', 5=>'പുത്ര', 6=>'ശത്രു', 7=>'കളത്ര', 8=>'ആയുർ', 9=>'ഭാഗ്യ', 10=>'കർമ്മ', 11=>'ലാഭ', 12=>'വ്യയ'];

        if ($lang === 'ml') {
            return "{$ord[$lordHouse]} ഭാവാധിപൻ ({$hName[$lordHouse]}ഭാവം) {$ord[$placedHouse]} ഭാവത്തിൽ: ഈ സ്ഥാനസ്ഥിതി ജാതകന്റെ {$hName[$lordHouse]}-{$hName[$placedHouse]} ഭാവങ്ങളുടെ കാരകത്വങ്ങളെ സവിശേഷമായി ഉദ്ദീപിപ്പിക്കുന്നു. അനുയോജ്യമായ ദശാപഹാരങ്ങളിൽ ഉന്നത നേട്ടങ്ങൾ പ്രദാനം ചെയ്യും.";
        }

        return "Lord of {$lordHouse}th House placed in {$placedHouse}th House: Integrates the portfolio of the {$lordHouse}th house with the dynamic platform of the {$placedHouse}th house, yielding progressive karmic realizations during operational dasha periods.";
    }

    /**
     * Get Planet in House Interpretation (with dignity modifier)
     */
    public static function getPlanetInHouseInterpretation(string $planet, int $house, string $dignity = 'neutral', string $lang = 'ml'): string
    {
        $key = "{$planet}_H{$house}";
        $entry = self::PLANET_IN_HOUSE_PLACEMENTS[$key] ?? null;

        $pNameMl = ['Su'=>'സൂര്യൻ', 'Mo'=>'ചന്ദ്രൻ', 'Ma'=>'കുജൻ (ചൊവ്വ)', 'Me'=>'ബുധൻ', 'Ju'=>'വ്യാഴം (ഗുരു)', 'Ve'=>'ശുക്രൻ', 'Sa'=>'ശനി', 'Ra'=>'രാഹു', 'Ke'=>'കേതു', 'Md'=>'ഗുളികൻ'][$planet] ?? $planet;
        $pNameEn = ['Su'=>'Sun', 'Mo'=>'Moon', 'Ma'=>'Mars', 'Me'=>'Mercury', 'Ju'=>'Jupiter', 'Ve'=>'Venus', 'Sa'=>'Saturn', 'Ra'=>'Rahu', 'Ke'=>'Ketu', 'Md'=>'Gulika'][$planet] ?? $planet;

        $baseText = '';
        if ($entry && isset($entry[$lang])) {
            $baseText = $entry[$lang];
        } elseif ($entry && isset($entry['en'])) {
            $baseText = $entry['en'];
        } else {
            $baseText = ($lang === 'ml')
                ? "{$pNameMl} {$house}-ാം ഭാവത്തിൽ ശുഭകരമായ ഫലപ്രദായകനായി വർത്തിക്കുന്നു. സ്വന്തം കാരുണ്യത്താൽ ജീവിതത്തിൽ ഐശ്വര്യവും വിജയവും പ്രദാനം ചെയ്യുന്നു."
                : "{$pNameEn} in House {$house} acts with dedicated influence, enhancing the organic potential of this sector.";
        }

        // Add dignity modifier note if exalted, own, debilitated, or combust
        if ($dignity === 'exalted') {
            $baseText .= ($lang === 'ml')
                ? " (ഉച്ചക്ഷേത്രസ്ഥിതിയാൽ അത്യുത്തമ ബലത്തോടെ ഫലങ്ങൾ പൂർണ്ണതയിലെത്തിക്കുന്നു)."
                : " (Exalted dignity grants maximum strength, manifesting the highest noble manifestations).";
        } elseif ($dignity === 'own') {
            $baseText .= ($lang === 'ml')
                ? " (സ്വക്ഷേത്രസ്ഥിതിയാൽ ആത്മവിശ്വാസത്തോടും അധികാരത്തോടും കൂടി ഭാവപുഷ്ടി നൽകുന്നു)."
                : " (Own sign placement anchors profound stability and protects the core portfolio).";
        } elseif ($dignity === 'debilitated') {
            $baseText .= ($lang === 'ml')
                ? " (നീചക്ഷേത്രസ്ഥിതിയാൽ പ്രാർത്ഥനകളും യഥാവിധി ശാന്തികർമ്മങ്ങളും അനുഷ്ഠിക്കുന്നത് ശ്രേയസ്സ് വർദ്ധിപ്പിക്കും)."
                : " (Debilitated dignity calls for conscious mindfulness and dedicated planetary remedies).";
        } elseif ($dignity === 'combust') {
            $baseText .= ($lang === 'ml')
                ? " (സൂര്യസാമീപ്യത്താൽ മൗഢ്യാവസ്ഥയിലായതിനാൽ ഈശ്വരോപാസന ശുഭഫലങ്ങൾക്ക് ആക്കം കൂട്ടും)."
                : " (Combustion suggests focusing on inner spiritual realization to revitalize its latent power).";
        }

        return $baseText;
    }

    /**
     * Compute Planetary Aspects (Drishti) on each of the 12 Bhavas
     */
    public static function getAspectsOnBhava(int $bhava, array $chartData, string $lang = 'ml'): array
    {
        $aspects = [];
        $planetBhavas = $chartData['planet_bhavas'] ?? [];

        foreach ($planetBhavas as $pk => $info) {
            $pBhava = $info['bhava'] ?? 0;
            if ($pBhava <= 0 || $pBhava === $bhava) {
                continue;
            }

            // Distance in houses counted from planet to target bhava
            $dist = (($bhava - $pBhava + 12) % 12) + 1;

            $hasAspect = false;
            $aspectType = '';

            // Universal 7th house aspect (Direct Full Aspect)
            if ($dist === 7) {
                $hasAspect = true;
                $aspectType = '7th_direct';
            }

            // Special Aspects:
            // Mars: 4th, 7th, 8th
            if ($pk === 'Ma' && in_array($dist, [4, 8], true)) {
                $hasAspect = true;
                $aspectType = "special_{$dist}th";
            }
            // Jupiter: 5th, 7th, 9th
            if ($pk === 'Ju' && in_array($dist, [5, 9], true)) {
                $hasAspect = true;
                $aspectType = "special_{$dist}th";
            }
            // Saturn: 3rd, 7th, 10th
            if ($pk === 'Sa' && in_array($dist, [3, 10], true)) {
                $hasAspect = true;
                $aspectType = "special_{$dist}th";
            }
            // Rahu & Ketu: 5th, 9th
            if (in_array($pk, ['Ra', 'Ke'], true) && in_array($dist, [5, 9], true)) {
                $hasAspect = true;
                $aspectType = "special_{$dist}th";
            }

            if ($hasAspect) {
                $aspects[] = self::getAspectNarrative($pk, $dist, $bhava, $aspectType, $lang);
            }
        }

        return $aspects;
    }

    /**
     * Construct meaningful narrative for a planetary aspect
     */
    protected static function getAspectNarrative(string $pk, int $dist, int $targetBhava, string $type, string $lang): array
    {
        $namesMl = [
            'Su' => 'സൂര്യന്റെ', 'Mo' => 'ചന്ദ്രന്റെ', 'Ma' => 'കുജന്റെ (ചൊവ്വയുടെ)',
            'Me' => 'ബുധന്റെ', 'Ju' => 'വ്യാഴത്തിന്റെ (ഗുരുവിന്റെ)', 'Ve' => 'ശുക്രന്റെ',
            'Sa' => 'ശനിയുടെ', 'Ra' => 'രാഹുവിന്റെ', 'Ke' => 'കേതുവിന്റെ', 'Md' => 'ഗുളികന്റെ',
        ];
        $namesEn = [
            'Su' => 'Sun', 'Mo' => 'Moon', 'Ma' => 'Mars',
            'Me' => 'Mercury', 'Ju' => 'Jupiter', 'Ve' => 'Venus',
            'Sa' => 'Saturn', 'Ra' => 'Rahu', 'Ke' => 'Ketu', 'Md' => 'Gulika',
        ];

        $pNameMl = $namesMl[$pk] ?? $pk;
        $pNameEn = $namesEn[$pk] ?? $pk;

        $descMl = '';
        $descEn = '';

        if ($pk === 'Ju') {
            $descMl = "{$pNameMl} ശുഭദൃഷ്ടി: {$targetBhava}-ാം ഭാവത്തിന് സവിശേഷമായ ദൈവിക സംരക്ഷണവും ശുദ്ധീകരണവും നൽകുന്നു. ദോഷങ്ങളെ ലഘൂകരിച്ച് ഐശ്വര്യം വർദ്ധിപ്പിക്കുന്നു.";
            $descEn = "Auspicious aspect of {$pNameEn}: Bestows divine grace, moral fortification, and shields the {$targetBhava}th house from negative vulnerabilities.";
        } elseif ($pk === 'Ve') {
            $descMl = "{$pNameMl} സൗമ്യദൃഷ്ടി: സന്തോഷം, സാമ്പത്തികാനുകൂല്യം, കലകളോടുള്ള അഭിരുചി എന്നിവ ഈ ഭാവഫലങ്ങളിൽ പകർന്നുനൽകുന്നു.";
            $descEn = "Benefic aspect of {$pNameEn}: Imparts grace, artistic harmony, material satisfaction, and cordial associations to the {$targetBhava}th house.";
        } elseif ($pk === 'Me') {
            $descMl = "{$pNameMl} ബുദ്ധിദൃഷ്ടി: കാര്യഗ്രഹണശേഷി, ചിന്താശക്തി, യുക്തിസഹമായ കാര്യനിർവ്വഹണം എന്നിവ ഉണർത്തുന്നു.";
            $descEn = "Intellectual aspect of {$pNameEn}: Stimulates discernment, adaptable reasoning, and effective communication.";
        } elseif ($pk === 'Mo') {
            $descMl = "{$pNameMl} സാത്വികദൃഷ്ടി: മാനസിക പ്രശാന്തിയും സമാധാനവും പ്രദാനം ചെയ്യുന്നു.";
            $descEn = "Luminary aspect of {$pNameEn}: Infuses emotional sensitivity, serenity, and pleasant domestic dispositions.";
        } elseif ($pk === 'Su') {
            $descMl = "{$pNameMl} തേജോമയദൃഷ്ടി: പ്രതാപം, കാര്യശേഷി, ആത്മാഭിമാനം എന്നിവ പ്രദാനം ചെയ്യുമ്പോൾ തന്നെ ചെറിയ തോതിലുള്ള കാർക്കശ്യം കൊണ്ടുവരാം.";
            $descEn = "Solar aspect of {$pNameEn}: Heightens self-respect, administrative authority, and willpower.";
        } elseif ($pk === 'Ma') {
            $descMl = "{$pNameMl} ഉഗ്രദൃഷ്ടി: അസാധാരണ ഊർജ്ജവും ധൈര്യവും നൽകുമ്പോൾ തന്നെ ക്ഷമയില്ലായ്മയും എടുത്തുചാട്ടവും നിയന്ത്രിക്കേണ്ടതുണ്ട്.";
            $descEn = "Dynamic aspect of {$pNameEn}: Infuses fiery momentum, driving courage, yet calls for patience against impulsive haste.";
        } elseif ($pk === 'Sa') {
            $descMl = "{$pNameMl} കർക്കശദൃഷ്ടി: കഠിനാധ്വാനം, അച്ചടക്കം, ക്ഷമാശീലം എന്നിവയിലൂടെ സുസ്ഥിരമായ നേട്ടങ്ങൾ ഉറപ്പുവരുത്തുന്നു.";
            $descEn = "Saturnine aspect of {$pNameEn}: Inculcates discipline, patient labor, and mature perseverance before yielding steady accomplishments.";
        } else {
            $descMl = "{$pNameMl} സ്വാധീനദൃഷ്ടി: ഈ ഭാവത്തിൽ സവിശേഷമായ കർമ്മഫലങ്ങൾ പ്രകടമാക്കുന്നു.";
            $descEn = "Planetary aspect of {$pNameEn}: Influences the organic themes of the {$targetBhava}th house.";
        }

        return [
            'planet' => $pk,
            'distance' => $dist,
            'aspect_type' => $type,
            'text' => ($lang === 'ml') ? $descMl : $descEn,
            'text_ml' => $descMl,
            'text_en' => $descEn,
        ];
    }

    /**
     * Master Dictionary of All 144 Bhava Lord Placements
     */
    public const BHAVA_LORD_PLACEMENTS = [
        // ---------------- HOUSE 1 LORD IN HOUSES 1 TO 12 ----------------
        'L1_H1' => [
            'ml' => 'ലഗ്നാധിപൻ ലഗ്നത്തിൽ തന്നെ സ്ഥിതിചെയ്യുന്നത് അത്യുത്തമമായ ദീർഘായുസ്സും, ശാരീരിക സൗഖ്യവും, ആകർഷകമായ വ്യക്തിത്വവും പ്രദാനം ചെയ്യുന്നു. സ്വതന്ത്ര ചിന്താഗതിയും ആത്മാഭിമാനവും ഇവരുടെ മുഖമുദ്രയാണ്. സ്വന്തം പരിശ്രമത്താൽ സമൂഹത്തിൽ ഉന്നത സ്ഥാനവും ജനസമ്മിതിയും കൈവരിക്കും.',
            'en' => 'Ascendant lord in the 1st House (Lagna) confers robust health, charismatic vitality, long life, and commendable self-reliance. The native is principled, dignified, and attains respected prominence through independent enterprise.',
        ],
        'L1_H2' => [
            'ml' => 'ലഗ്നാധിപൻ രണ്ടാം ഭാവത്തിൽ (ധനഭാവം) നിൽക്കുന്നത് മികച്ച വാക്ചാതുര്യവും, സാമ്പത്തിക വളർച്ചയും, കുടുംബ സ്നേഹവും സമ്മാനിക്കുന്നു. കഠിനാധ്വാനത്തിലൂടെ സമ്പത്ത് വർദ്ധിപ്പിക്കും. ധാർമ്മികമായ സമ്പാദ്യരീതിയും ഉദാരമായ ദാനശീലവും പ്രകടിപ്പിക്കും.',
            'en' => 'Ascendant lord in the 2nd House creates exceptional communicative power, steady wealth accretion, and sincere family devotion. The native generates sustained prosperity through honorable personal labor.',
        ],
        'L1_H3' => [
            'ml' => 'ലഗ്നാധിപൻ മൂന്നാം ഭാവത്തിൽ (സഹജഭാവം) നിൽക്കുന്നത് സാഹസികത, അസാധാരണ ധൈര്യം, സഹോദര സൗഖ്യം, സംഗീത-കലാ വാസനകൾ എന്നിവ നൽകുന്നു. ആരുടെയും ആശ്രയമില്ലാതെ സ്വന്തം കൈക്കരുത്തുകൊണ്ട് ജീവിതവിജയം സ്വന്തമാക്കും.',
            'en' => 'Ascendant lord in the 3rd House imparts resolute courage, enterprise, fraternal affection, and affinity for fine arts. The native relies on personal initiative to conquer challenging conditions.',
        ],
        'L1_H4' => [
            'ml' => 'ലഗ്നാധിപൻ നാലാം ഭാവത്തിൽ (സുഖഭാവം) നിൽക്കുന്നത് മാതൃസൗഖ്യം, സ്വന്തമായി ഭൂമി, ഭവനം, വാഹനങ്ങൾ എന്നിവ സമ്മാനിക്കുന്നു. വിദ്യാഗുണവും, ബന്ധുമിത്രാദികളുടെ സ്നേഹവും, മനഃസ്സമാധാനവും എപ്പോഴും അനുഭവിക്കും.',
            'en' => 'Ascendant lord in the 4th House ensures maternal blessings, prime real estate, domestic comfort, and conveyances. Endows scholarly aptitude, loyal friendships, and profound mental tranquility.',
        ],
        'L1_H5' => [
            'ml' => 'ലഗ്നാധിപൻ അഞ്ചാം ഭാവത്തിൽ (പൂർവ്വപുണ്യഭാവം) സ്ഥിതിചെയ്യുന്നത് അസാധാരണ ബുദ്ധിസാമർത്ഥ്യം, സൽസന്താനയോഗം, ഈശ്വരാനുഗ്രഹം എന്നിവ നൽകുന്നു. ഉപദേശക സ്ഥാനങ്ങളിലും നയതന്ത്രരംഗത്തും തിളങ്ങും. പൂർവ്വജന്മ പുണ്യം എപ്പോഴും കൂടെയുണ്ടാകും.',
            'en' => 'Ascendant lord in the 5th House activates exceptional creative intellect, noble progeny, and abundant spiritual merits. The native excels in counselling, diplomacy, and receives auspicious divine support.',
        ],
        'L1_H6' => [
            'ml' => 'ലഗ്നാധിപൻ ആറാം ഭാവത്തിൽ (ശത്രു-രോഗ ഭാവം) നിൽക്കുന്നത് ശത്രുജയവും, പ്രതിസന്ധികളെ അവസരങ്ങളാക്കി മാറ്റാനുള്ള പോരാട്ടവീര്യവും നൽകുന്നു. ആരോഗ്യകാര്യങ്ങളിൽ കൃത്യമായ ശ്രദ്ധയും വ്യായാമവും ശീലമാക്കുന്നത് ഉത്തമമായിരിക്കും.',
            'en' => 'Ascendant lord in the 6th House confers combative grit to overcome competition, lawsuits, and rivals. Regular physical fitness, balanced diet, and stress management ensure enduring health.',
        ],
        'L1_H7' => [
            'ml' => 'ലഗ്നാധിപൻ ഏഴാം ഭാവത്തിൽ (കളത്രഭാവം) നിൽക്കുന്നത് ഉത്തമ സ്വഭാവമുള്ള ജീവിതപങ്കാളിയെയും, മാന്യമായ ദാമ്പത്യ സൗഖ്യവും നൽകുന്നു. വിദേശബന്ധങ്ങൾ, പൊതുജനസമ്പർക്കം, പങ്കാളിത്ത ബിസിനസ്സുകൾ എന്നിവയിൽ ശോഭിക്കും.',
            'en' => 'Ascendant lord in the 7th House bestows a noble, attractive life partner and enduring marital affection. The native excels in public relations, overseas engagements, and collaborative ventures.',
        ],
        'L1_H8' => [
            'ml' => 'ലഗ്നാധിപൻ എട്ടാം ഭാവത്തിൽ (ആയുർഭാവം) നിൽക്കുന്നത് ഗൂഢശാസ്ത്രങ്ങളിലും ആത്മീയ ഗവേഷണങ്ങളിലും താല്പര്യം നൽകുന്നു. പെട്ടെന്നുള്ള ധനലാഭങ്ങൾക്കും പൂർവ്വിക സ്വത്തുക്കൾക്കും സാധ്യതയുണ്ട്. ആത്മീയ సాధനകൾ മനസ്സിന് വലിയ ഉന്മേഷം നൽകും.',
            'en' => 'Ascendant lord in the 8th House sparks keen interest in occult philosophy, transformative spirituality, and research. Grants sudden gains or legacy, with profound intuitive perception.',
        ],
        'L1_H9' => [
            'ml' => 'ലഗ്നാധിപൻ ഒമ്പതാം ഭാവത്തിൽ (ഭാഗ്യഭാവം) നിൽക്കുന്നത് ഭാഗ്യവാനും സൽക്കർമ്മനിരതനുമായ വ്യക്തിത്വം സൃഷ്ടിക്കുന്നു. പിതൃസൗഖ്യം, തീർത്ഥാടനങ്ങൾ, സമൂഹത്തിൽ ഉയർന്ന ബഹുമാന്യത എന്നിവ നൽകുന്നു. ജീവിതത്തിലുടനീളം ഭാഗ്യദേവതയുടെ കടാക്ഷമുണ്ടാകും.',
            'en' => 'Ascendant lord in the 9th House produces a fortunate, righteous, and highly respected native. Enjoys paternal blessings, sacred travels, and sustained auspicious providence.',
        ],
        'L1_H10' => [
            'ml' => 'ലഗ്നാധിപൻ പത്താം ഭാവത്തിൽ (കർമ്മഭാവം) നിൽക്കുന്നത് പ്രൊഫഷണൽ രംഗത്ത് ഉന്നതമായ അധികാരവും നേതൃപദവിയും സമ്മാനിക്കുന്നു. കഠിനാധ്വാനത്തിലൂടെ സ്വന്തം കർമ്മമേഖലയിൽ വ്യക്തിമുദ്ര പതിപ്പിക്കുകയും സൽക്കീർത്തി നേടുകയും ചെയ്യും.',
            'en' => 'Ascendant lord in the 10th House establishes prominent executive authority, occupational distinction, and public acclaim. The native earns enduring renown through self-directed enterprise.',
        ],
        'L1_H11' => [
            'ml' => 'ലഗ്നാധിപൻ പതിനൊന്നാം ഭാവത്തിൽ (ലാഭഭാവം) നിൽക്കുന്നത് ആഗ്രഹസാഫല്യവും, സർവ്വവിധ സാമ്പത്തിക അഭിവൃദ്ധിയും, വിശാലമായ സൗഹൃദവലയവും നൽകുന്നു. ചെയ്യുന്ന ഏതു കാര്യത്തിലും ലാഭം കൊയ്യാനുള്ള വിരുതുണ്ടാകും.',
            'en' => 'Ascendant lord in the 11th House guarantees fulfillment of aspirations, manifold financial revenues, and influential social networks. Endeavors consistently yield profitable fruits.',
        ],
        'L1_H12' => [
            'ml' => 'ലഗ്നാധിപൻ പന്ത്രണ്ടാം ഭാവത്തിൽ (വ്യയഭാവം) നിൽക്കുന്നത് വിദേശവാസത്തിനും, ആത്മീയ നിഷ്ഠകൾക്കും, ജീവകാരുണ്യ പ്രവർത്തനങ്ങൾക്കും വഴിയൊരുക്കുന്നു. നിസ്വാർത്ഥമായ പരോപകാര ചിന്തയും ഈശ്വരാരാധനയും മനഃസ്സമാധാനം തരും.',
            'en' => 'Ascendant lord in the 12th House favors foreign relocation, philanthropic benevolence, and contemplative spirituality. Cultivates selfless charity and inner detachment.',
        ],

        // ---------------- HOUSE 2 LORD IN HOUSES 1 TO 12 ----------------
        'L2_H1' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് കുടുംബത്തിന്റെ അഭിമാനമായി മാറുന്നതിനും, സ്വന്തം വാക്സാമർത്ഥ്യത്താൽ സമ്പത്ത് ആർജ്ജിക്കുന്നതിനും സഹായിക്കുന്നു. ആകർഷകമായ സംസാരരീതിയും സാമ്പത്തിക ബുദ്ധിയുമുണ്ടാകും.',
            'en' => '2nd lord in 1st House elevates family pride and generates steady wealth through persuasive speech and personal intellect. Endows commercial dexterity and financial prudence.',
        ],
        'L2_H2' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ രണ്ടിൽ തന്നെ നിൽക്കുന്നത് മഹാധനയോഗമാണ്. കുടുംബത്തിൽ സമാധാനവും, സമ്പാദ്യത്തിൽ സ്ഥിരതയും, സരസ്വതീ കടാക്ഷവും ഉറപ്പുനൽകുന്നു. വാഗ്ദാനങ്ങൾ പാലിക്കുന്നതിൽ വിട്ടുവീഴ്ച കാണിക്കില്ല.',
            'en' => '2nd lord in its own 2nd House creates outstanding Dhana Yoga, conferring steady financial assets, flawless truthful speech, and harmonious domestic peace.',
        ],
        'L2_H3' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് സഹോദരങ്ങളുമായുള്ള സാമ്പത്തിക പങ്കാളിത്തവും, സംഗീതം, എഴുത്ത്, മാധ്യമങ്ങൾ എന്നിവയിലൂടെ ധനാഗമവും സമ്മാനിക്കുന്നു. സ്വന്തം ധൈര്യം കൊണ്ട് പണം സമ്പാദിക്കും.',
            'en' => '2nd lord in 3rd House brings wealth through creative writing, media, fraternal collaboration, and courageous personal ventures.',
        ],
        'L2_H4' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് റിയൽ എസ്റ്റേറ്റ്, വാഹനങ്ങൾ, കാർഷികം, മാതൃസ്വത്ത് എന്നിവയിലൂടെ വലിയ ധനസമ്പാദനത്തിന് വഴിയൊരുക്കുന്നു. കുടുംബത്തിൽ സകല ഭൗതിക സൗകര്യങ്ങളും അനുഭവിക്കും.',
            'en' => '2nd lord in 4th House brings substantial wealth through real estate, maternal inheritances, agricultural yields, and fine vehicular assets.',
        ],
        'L2_H5' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഓഹരികൾ, ഊഹക്കച്ചവടം, ബുദ്ധിപരമായ നിക്ഷേപങ്ങൾ എന്നിവയിലൂടെ അപ്രതീക്ഷിത ധനലാഭം നൽകുന്നു. മക്കൾ സാമ്പത്തികമായി ഉന്നത നിലയിലെത്തും.',
            'en' => '2nd lord in 5th House activates lucrative financial intelligence, speculative acumen, investment gains, and prosperous children.',
        ],
        'L2_H6' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് ബാങ്കിംഗ്, വായ്പകൾ, നിയമപരമായ കാര്യങ്ങൾ എന്നിവയിലൂടെ പണം കണ്ടെത്താൻ സഹായിക്കുന്നു. സാമ്പത്തിക ഇടപാടുകളിൽ ശ്രദ്ധയും കൃത്യമായ കണക്കുകളും സൂക്ഷിക്കുന്നത് ഉചിതമാണ്.',
            'en' => '2nd lord in 6th House indicates gains through financial services, competitive enterprises, or litigation, with need for prudent accounting against disputed debts.',
        ],
        'L2_H7' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് ജീവിതപങ്കാളിയിലൂടെയോ പങ്കാളിത്ത ബിസിനസ്സിലൂടെയോ ധനസമ്പാദനത്തിന് ഇടയാക്കുന്നു. വിദേശത്തുനിന്നുള്ള വരുമാനത്തിനും നല്ല സാധ്യതയുണ്ട്.',
            'en' => '2nd lord in 7th House facilitates financial accretion through marriage, spouse\'s prosperous background, commercial trade, and cross-border commerce.',
        ],
        'L2_H8' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് പൂർവ്വിക സ്വത്തുക്കൾ, ഇൻഷുറൻസ്, അവിചാരിത ധനാഗമം എന്നിവ സമ്മാനിക്കും. സാമ്പത്തികമായ ഉയർച്ചതാഴ്ചകളിൽ മനസ്സ് പതറാതെ നോക്കണം.',
            'en' => '2nd lord in 8th House brings inheritances, unexpected windfalls, and spousal family assets, requiring systematic wealth preservation against sudden fluctuations.',
        ],
        'L2_H9' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് പിതൃധനവും, ഭാഗ്യപരമായ സാമ്പത്തിക മുന്നേറ്റവും, ധാർമ്മികമായ തൊഴിലിലൂടെയുള്ള ധനസമ്പാദനവും ഉറപ്പുനൽകുന്നു. ധനം സത്കർമ്മങ്ങൾക്കായി വിനിയോഗിക്കും.',
            'en' => '2nd lord in 9th House guarantees righteous wealth, paternal prosperity, and auspicious financial windfalls employed in philanthropic works.',
        ],
        'L2_H10' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് ഔദ്യോഗിക പദവികളിലൂടെയും, സർക്കാർ ആനുകൂല്യങ്ങളിലൂടെയും, പ്രൊഫഷണൽ ബിസിനസ്സിലൂടെയും സ്ഥിരമായ ഉന്നത വരുമാനം ഉറപ്പാക്കുന്നു.',
            'en' => '2nd lord in 10th House establishes distinguished income streams through executive positions, professional authority, and commercial reputation.',
        ],
        'L2_H11' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് പരമോന്നത ധനയോഗമാണ്. വരുമാന സ്രോതസ്സുകൾ നിരന്തരം വർദ്ധിക്കുകയും, ചെറിയ നിക്ഷേപങ്ങൾ പോലും വലിയ ലാഭമായി മാറുകയും ചെയ്യും.',
            'en' => '2nd lord in 11th House forms an exalted Dhana Yoga, multiplying income channels and turning small investments into substantial wealth accruals.',
        ],
        'L2_H12' => [
            'ml' => 'രണ്ടാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശത്തുനിന്നുള്ള വരുമാനത്തിനും, ജീവകാരുണ്യപരമായ ചെലവുകൾക്കും വഴിയൊരുക്കുന്നു. അനാവശ്യ ചെലവുകൾ നിയന്ത്രിച്ച് സമ്പാദ്യം വർദ്ധിപ്പിക്കാൻ ശ്രദ്ധിക്കണം.',
            'en' => '2nd lord in 12th House indicates earnings from foreign lands and significant expenditure on righteous charity and institutional welfare.',
        ],

        // ---------------- HOUSE 3 LORD IN HOUSES 1 TO 12 ----------------
        'L3_H1' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് സ്വന്തം ധീരതയാലും പ്രതിഭയാലും സമൂഹത്തിൽ പേരെടുക്കാൻ സഹായിക്കുന്നു. സാഹസികമായ സംരംഭങ്ങളിൽ താല്പര്യം കാണിക്കും.',
            'en' => '3rd lord in 1st House fosters courageous initiative, self-made drive, athletic prowess, and expressive leadership.',
        ],
        'L3_H2' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് ആശയവിനിമയം, എഴുത്ത്, സംഭാഷണം എന്നിവയിലൂടെ സാമ്പത്തിക നേട്ടങ്ങൾ സമ്മാനിക്കുന്നു. സഹോദരങ്ങളുടെ പിന്തുണ ഗുണം ചെയ്യും.',
            'en' => '3rd lord in 2nd House converts communication skills, trade, and media endeavors into profitable monetary returns.',
        ],
        'L3_H3' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ മൂന്നിൽ തന്നെ നിൽക്കുന്നത് അപാരമായ ധൈര്യവും, സാഹസികതയും, സഹോദര ഐക്യവും നൽകുന്നു. തടസ്സങ്ങളെ നിഷ്പ്രഭമാക്കാനുള്ള ഇച്ഛാശക്തിയുണ്ടാകും.',
            'en' => '3rd lord in own 3rd House reinforces resolute bravery, athletic stamina, fraternal solidarity, and fearlessness in negotiations.',
        ],
        'L3_H4' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് ഗൃഹനിർമ്മാണത്തിലും മാതൃസഹായത്തിലും സഹോദരങ്ങളുടെ പങ്കാളിത്തം ഉറപ്പാക്കുന്നു. വിദ്യാഭ്യാസത്തിൽ പ്രായോഗിക ബുദ്ധി പ്രകടിപ്പിക്കും.',
            'en' => '3rd lord in 4th House brings domestic support from siblings, practical education, and properties acquired through personal courage.',
        ],
        'L3_H5' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് കലാസാഹിത്യ രംഗങ്ങളിൽ ഉന്നതമായ സർഗ്ഗാത്മകതയും, രചനാപാടവവും, കുട്ടികളിലൂടെ അഭിമാനവും സമ്മാനിക്കുന്നു.',
            'en' => '3rd lord in 5th House stimulates creative literary writing, dramatic arts, theatrical pursuits, and innovative technical designs.',
        ],
        'L3_H6' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് മത്സരപരീക്ഷകളിലും ശത്രുക്കളുടെ മേലും നിർണ്ണായക വിജയം നൽകുന്നു. കഠിനാധ്വാനം ചെയ്യുന്നതിൽ ഒരിക്കലും മടിക്കില്ല.',
            'en' => '3rd lord in 6th House grants decisive victory over competitors, legal challenges, and rivals through sheer perseverance.',
        ],
        'L3_H7' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് ജീവിതപങ്കാളിക്ക് ധൈര്യവും കാര്യപ്രാപ്തിയും സമ്മാനിക്കുന്നു. യാത്രകളിലൂടെയും പൊതുബന്ധങ്ങളിലൂടെയും നേട്ടങ്ങളുണ്ടാകും.',
            'en' => '3rd lord in 7th House indicates an enterprising spouse, extensive business travels, and profitable collaborative agreements.',
        ],
        'L3_H8' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് രഹസ്യാന്വേഷണങ്ങളിലും ആഴത്തിലുള്ള ഗവേഷണങ്ങളിലും താല്പര്യം നൽകുന്നു. പെട്ടെന്നുള്ള യാത്രകൾക്ക് സാധ്യതയുണ്ട്.',
            'en' => '3rd lord in 8th House sparks aptitude for occult investigation, forensic research, and unexpected transformational travels.',
        ],
        'L3_H9' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് പിതാവുമായുള്ള ആശയവിനിമയ മികവും, തീർത്ഥാടന യാത്രകളും, ധാർമ്മികമായ ധീരതയും പ്രദാനം ചെയ്യുന്നു.',
            'en' => '3rd lord in 9th House aligns personal courage with spiritual righteousness, fostering philosophical travels and publications.',
        ],
        'L3_H10' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് മാധ്യമങ്ങൾ, എഴുത്ത്, ഗതാഗതം, സൈനികരംഗം, കായികരംഗം എന്നിവയിലൂടെ തൊഴിൽപരമായ ഉന്നതി നൽകുന്നു.',
            'en' => '3rd lord in 10th House establishes distinguished careers in journalism, communications, transport, sports, and executive logistics.',
        ],
        'L3_H11' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് സ്വന്തം കഴിവുകളിലൂടെ വലിയ ലാഭവും, ശക്തരായ സുഹൃത്തുക്കളുടെ പിന്തുണയും, ആഗ്രഹസാഫല്യവും നൽകുന്നു.',
            'en' => '3rd lord in 11th House converts self-driven initiatives and fraternal partnerships into lucrative profits and influential allies.',
        ],
        'L3_H12' => [
            'ml' => 'മൂന്നാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശ യാത്രകൾക്കും, വിദേശ വാസത്തിനും, നിശബ്ദമായ സേവനപ്രവർത്തനങ്ങൾക്കും അനുകൂലമാണ്.',
            'en' => '3rd lord in 12th House stimulates overseas assignments, spiritual retreats, and solitary creative accomplishments.',
        ],

        // ---------------- HOUSE 4 LORD IN HOUSES 1 TO 12 ----------------
        'L4_H1' => [
            'ml' => 'നാലാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ഉന്നത വിദ്യാഭ്യാസം, മാതൃസ്നേഹം, സ്വന്തമായി വീടും വാഹനങ്ങളും, സമൂഹത്തിൽ നല്ലൊരു കുടുംബപാരമ്പര്യവും സമ്മാനിക്കുന്നു.',
            'en' => '4th lord in 1st House bestows excellent higher education, maternal affection, landed estates, fine conveyances, and respectable lineage.',
        ],
        'L4_H2' => [
            'ml' => 'നാലാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് ഭൂമി, റിയൽ എസ്റ്റേറ്റ്, കാർഷികോല്പന്നങ്ങൾ എന്നിവയിലൂടെ സാമ്പത്തിക വളർച്ചയും കുടുംബത്തിൽ സന്തോഷവും നൽകുന്നു.',
            'en' => '4th lord in 2nd House brings substantial earnings through properties, agricultural produce, real estate, and familial stability.',
        ],
        'L4_H3' => [
            'ml' => 'നാലാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് സ്വന്തം അധ്വാനത്താൽ വീടും വാഹനങ്ങളും നിർമ്മിക്കാൻ സഹായിക്കുന്നു. സഹോദരങ്ങളുമായി ഗൃഹസൗഖ്യം പങ്കിടും.',
            'en' => '4th lord in 3rd House drives self-made acquisition of real estate, technical education, and amicable relations with siblings.',
        ],
        'L4_H4' => [
            'ml' => 'നാലാം ഭാവാധിപൻ നാലിൽ തന്നെ നിൽക്കുന്നത് മാതൃഭദ്രത, ആഡംബര ഭവനങ്ങൾ, സുഖസൗകര്യങ്ങൾ, മനഃസ്സമാധാനം എന്നിവ നൽകുന്ന മഹാഭാഗ്യയോഗമാണ്.',
            'en' => '4th lord in own 4th House creates profound domestic bliss, palatial residence, high academic accolades, and unwavering peace of mind.',
        ],
        'L4_H5' => [
            'ml' => 'നാലാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഉന്നതവിദ്യാഭ്യാസത്തിൽ റാങ്കുകളും അവാർഡുകളും, മക്കളിലൂടെ വലിയ സന്തോഷവും, പൂർവ്വപുണ്യാനുഭവങ്ങളും നൽകുന്നു.',
            'en' => '4th lord in 5th House generates brilliant scholastic distinctions, joyful progeny, and ancestral spiritual dividends.',
        ],
        'L4_H6' => [
            'ml' => 'നാലാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് വീടും സ്ഥലവുമായി ബന്ധപ്പെട്ട പ്രശ്നങ്ങളെ സമർത്ഥമായി പരിഹരിക്കാൻ സഹായിക്കുന്നു. മാതൃആരോഗ്യത്തിൽ ശ്രദ്ധ വേണം.',
            'en' => '4th lord in 6th House requires vigilance regarding maternal health and property legalities, resolving them through patience.',
        ],
        'L4_H7' => [
            'ml' => 'നാലാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് ജീവിതപങ്കാളിക്ക് സ്വന്തമായി വീടും സ്വത്തുക്കളും ഉണ്ടാവാനും, ദാമ്പത്യത്തിൽ ഭൗതിക സുഖസൗകര്യങ്ങൾ നിറയാനും കാരണമാകും.',
            'en' => '4th lord in 7th House indicates a spouse from an affluent, cultured family with landed wealth and domestic support.',
        ],
        'L4_H8' => [
            'ml' => 'നാലാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് പൂർവ്വിക ഗൃഹങ്ങൾ ലഭിക്കാനും, ആത്മീയ പഠനങ്ങളിൽ മനസ്സ് ഏകാഗ്രമാക്കാനും സഹായിക്കും. മനസ്സിന് ധ്യാനം ഉത്തമമാണ്.',
            'en' => '4th lord in 8th House favors ancestral estates and esoteric studies, counseling meditation to maintain emotional equilibrium.',
        ],
        'L4_H9' => [
            'ml' => 'നാലാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ഉന്നതവിദ്യാഭ്യാസത്തിനായി വിദേശയാത്രകൾ, പിതൃസഹായത്തോടെ വലിയ വീട്, ഭാഗ്യാനുഭവങ്ങൾ എന്നിവ നൽകുന്നു.',
            'en' => '4th lord in 9th House promotes foreign higher education, ancestral paternal wealth, palatial properties, and noble happiness.',
        ],
        'L4_H10' => [
            'ml' => 'നാലാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് വിദ്യാഭ്യാസ രംഗത്തോ റിയൽ എസ്റ്റേറ്റിലോ രാഷ്ട്രീയത്തിലോ ഉന്നതമായ തൊഴിൽവിജയം സമ്മാനിക്കുന്ന കർമ്മാധിപത്യമാണ്.',
            'en' => '4th lord in 10th House links domestic comforts to professional prestige in education, real estate, architecture, or government.',
        ],
        'L4_H11' => [
            'ml' => 'നാലാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് ഭൂമിവില്പനയിലൂടെയും വാടകവരുമാനത്തിലൂടെയും സ്ഥിരമായ വലിയ ലാഭവും, സന്തുഷ്ടമായ കുടുംബജീവിതവും നൽകുന്നു.',
            'en' => '4th lord in 11th House yields substantial rental yields, real estate profits, vehicular upgrades, and supportive elder mentors.',
        ],
        'L4_H12' => [
            'ml' => 'നാലാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് സ്വന്തം ജന്മനാട്ടിൽ നിന്നകന്ന് വിദേശത്തോ അന്യദേശത്തോ സ്വന്തമായി വീട് നിർമ്മിച്ച് സമാധാനത്തോടെ ജീവിക്കാൻ വഴിയൊരുക്കുന്നു.',
            'en' => '4th lord in 12th House favors establishing luxurious domestic abodes in distant lands or overseas spiritual environments.',
        ],

        // ---------------- HOUSE 5 LORD IN HOUSES 1 TO 12 ----------------
        'L5_H1' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് തികഞ്ഞ ബുദ്ധിരാക്ഷസനും, ഈശ്വരാനുഗ്രഹമുള്ളവനും, പണ്ഡിതനുമാക്കുന്നു. ജനങ്ങൾ ഇദ്ദേഹത്തിന്റെ ഉപദേശങ്ങൾ തേടിയെത്തും.',
            'en' => '5th lord in 1st House endows exceptional intellectual brilliance, moral integrity, creative genius, and advisory prestige.',
        ],
        'L5_H2' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് സ്വന്തം ബുദ്ധിസാമർത്ഥ്യത്താലും വിജ്ഞാനത്താലും വലിയ ധനം സമ്പാദിക്കാൻ സഹായിക്കുന്നു. നല്ല വാക്ചാതുര്യമുണ്ടാകും.',
            'en' => '5th lord in 2nd House converts scholarly wisdom and creative ideas into substantial, enduring financial prosperity.',
        ],
        'L5_H3' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് എഴുത്ത്, കല, സംഗീതം എന്നിവയിലൂടെ പ്രശസ്തിയും, സഹോദരങ്ങൾക്ക് ഉന്നത വിദ്യാഭ്യാസവും സമ്മാനിക്കുന്നു.',
            'en' => '5th lord in 3rd House manifests in creative writing, fine arts, musical composition, and fraternal accomplishments.',
        ],
        'L5_H4' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് പൂർവ്വപുണ്യത്താൽ ലഭിക്കുന്ന ഉന്നത വിദ്യാഭ്യാസം, വിദ്യാലയങ്ങളുമായി ബന്ധപ്പെട്ട നേട്ടങ്ങൾ, കുടുംബസന്തോഷം എന്നിവ നൽകുന്നു.',
            'en' => '5th lord in 4th House brings academic laurels, institutional leadership, domestic joy, and blessings of learned mentors.',
        ],
        'L5_H5' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ അഞ്ചിൽ തന്നെ നിൽക്കുന്നത് പൂർവ്വപുണ്യ യോഗമാണ്. സൽസന്താനങ്ങൾ, മന്ത്രിപദവിക്ക് തുല്യമായ ഉപദേശക പദവി, അഗാധമായ ഈശ്വരഭക്തി എന്നിവ സമ്മാനിക്കുന്നു.',
            'en' => '5th lord in own 5th House creates a paramount Purva Punya Yoga, granting brilliant progeny, statesmanlike counsel, and mantra siddhi.',
        ],
        'L5_H6' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് മത്സരപരീക്ഷകളിലും ഗവേഷണങ്ങളിലും മികച്ച വിജയം നൽകുന്നു. മക്കളുടെ ആരോഗ്യത്തിൽ ചെറിയ മുൻകരുതലുകൾ ഉത്തമം.',
            'en' => '5th lord in 6th House confers mastery in competitive examinations and legal diagnostics, with focus on children\'s routine health.',
        ],
        'L5_H7' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് വിദ്യാസമ്പന്നയും സദ്ഗുണസമ്പന്നയുമായ ജീവിതപങ്കാളിയെയും, മാതൃകാപരമായ പ്രണയസാഫല്യത്തെയും സൂചിപ്പിക്കുന്നു.',
            'en' => '5th lord in 7th House unites the native with an educated, cultured spouse, ensuring romantic fulfillment and mutual respect.',
        ],
        'L5_H8' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് ആഴത്തിലുള്ള ആത്മീയത, യോഗവിദ്യ, പൂർവ്വിക രഹസ്യങ്ങൾ എന്നിവ ഗ്രഹിക്കാനുള്ള നൈസർഗ്ഗിക ശേഷി നൽകുന്നു.',
            'en' => '5th lord in 8th House sparks occult intuition, deep philosophical meditation, and transformative esoteric breakthroughs.',
        ],
        'L5_H9' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ത്രികോണാധിപന്മാർ തമ്മിലുള്ള പരമോന്നത ഭാഗ്യയോഗമാണ്. ഈശ്വരകൃപയാൽ സകല കാര്യങ്ങളിലും വിജയം സുനിശ്ചിതമായിരിക്കും.',
            'en' => '5th lord in 9th House forms a supreme Dharma-Karmadhipati/Trikona alliance, ensuring continuous spiritual grace and good fortune.',
        ],
        'L5_H10' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് വിദ്യാഭ്യാസം, ഭരണം, സാമ്പത്തിക ഉപദേശം, ജുഡീഷ്യറി എന്നിവയിൽ ഉന്നത പദവികൾ നേടാൻ വഴിയൊരുക്കുന്നു.',
            'en' => '5th lord in 10th House establishes distinguished careers in governance, advisory leadership, pedagogy, and strategic management.',
        ],
        'L5_H11' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് വിജ്ഞാനത്തിലൂടെയും സർഗ്ഗാത്മക സംരംഭങ്ങളിലൂടെയും വലിയ ലാഭവും, കുട്ടികളിലൂടെ സകലവിധ അഭിമാനവും നൽകുന്നു.',
            'en' => '5th lord in 11th House produces manifold financial profits through intellectual properties and brings immense pride through children.',
        ],
        'L5_H12' => [
            'ml' => 'അഞ്ചാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശത്ത് വിജ്ഞാനസമ്പാദനത്തിനും, ആത്മീയ സാധനകളിലൂടെ മോക്ഷമാർഗ്ഗം തെളിയുന്നതിനും കാരണമാകും.',
            'en' => '5th lord in 12th House favors foreign academic pursuits, meditative retreats, and attainment of contemplative spiritual insight.',
        ],

        // ---------------- HOUSE 6 LORD IN HOUSES 1 TO 12 ----------------
        'L6_H1' => [
            'ml' => 'ആറാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ശത്രുക്കളെ നേരിടാനുള്ള അസാധാരണ പോരാട്ടവീര്യം നൽകുന്നു. ആഹാരനിയന്ത്രണവും ശാന്തതയും പാലിക്കുന്നത് ഉത്തമം.',
            'en' => '6th lord in 1st House imparts warrior-like resilience to confront adversaries, advising dietary moderation and mindfulness.',
        ],
        'L6_H2' => [
            'ml' => 'ആറാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് സാമ്പത്തിക ഇടപാടുകളിൽ കൃത്യതയും ജാഗ്രതയും പാലിക്കേണ്ടതിന്റെ ആവശ്യകത ചൂണ്ടിക്കാണിക്കുന്നു. ബാങ്കിംഗിൽ നേട്ടമുണ്ടാക്കാം.',
            'en' => '6th lord in 2nd House advises strict financial accounting against disputed dues, favoring professional roles in banking.',
        ],
        'L6_H3' => [
            'ml' => 'ആറാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് അതിയായ പരിശ്രമശേഷിയും, പ്രതിബന്ധങ്ങളെ തകർത്തെറിയാനുള്ള തന്റേടവും സമ്മാനിക്കുന്നു.',
            'en' => '6th lord in 3rd House reinforces intense combative energy, overcoming disputes through decisive action and courage.',
        ],
        'L6_H4' => [
            'ml' => 'ആറാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് കുടുംബസ്വത്ത് തർക്കങ്ങൾ രമ്യമായി പരിഹരിക്കാൻ ഉപകരിക്കും. മനഃസ്സമാധാനത്തിന് വിഷ്ണുഭജനം ഉത്തമമാണ്.',
            'en' => '6th lord in 4th House counsels patience in resolving real estate documentation, fostering home harmony via spiritual discipline.',
        ],
        'L6_H5' => [
            'ml' => 'ആറാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് മത്സരപരീക്ഷകളിലും ഗവേഷണങ്ങളിലും ശത്രുക്കളെ പിന്തള്ളി ഒന്നാമതെത്താൻ സഹായിക്കുന്നു.',
            'en' => '6th lord in 5th House sharpens critical analytical faculties, excelling in high-stakes competitive examinations.',
        ],
        'L6_H6' => [
            'ml' => 'ആറാം ഭാവാധിപൻ ആറിൽ തന്നെ നിൽക്കുന്നത് ഹർഷ യോഗമാണ് (വിപരീത രാജയോഗം). ശത്രുക്കൾ സ്വയം കീഴടങ്ങുകയും, എല്ലാവിധ രോഗദുരിതങ്ങളിൽ നിന്നും വേഗത്തിൽ മുക്തി ലഭിക്കുകയും ചെയ്യും.',
            'en' => '6th lord in own 6th House forms Harsha Yoga (Viparita Raja Yoga), totally dissolving adversary threats and conferring robust immunity.',
        ],
        'L6_H7' => [
            'ml' => 'ആറാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് പങ്കാളിയോട് തുറന്ന മനസ്സോടെ ഇടപെടാനും പരസ്പര വിട്ടുവീഴ്ചകൾ ചെയ്യാനും ഓർമ്മിപ്പിക്കുന്നു.',
            'en' => '6th lord in 7th House emphasizes empathetic communication and cordial mutual respect in marital partnerships.',
        ],
        'L6_H8' => [
            'ml' => 'ആറാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് വിപരീത രാജയോഗ ഫലങ്ങൾ നൽകുന്നു. അപ്രതീക്ഷിതമായി തടസ്സങ്ങൾ ഒഴിഞ്ഞുമാറുകയും ഭാഗ്യം തുണയ്ക്കുകയും ചെയ്യും.',
            'en' => '6th lord in 8th House creates a powerful Viparita Raja Yoga, transmuting sudden obstacles into unexpected breakthroughs.',
        ],
        'L6_H9' => [
            'ml' => 'ആറാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ധർമ്മമാർഗ്ഗത്തിലൂടെ തടസ്സങ്ങൾ അതിജീവിക്കാനും വിദേശത്ത് നിയമവിജയങ്ങൾ നേടാനും സഹായിക്കും.',
            'en' => '6th lord in 9th House indicates overcoming judicial challenges abroad through ethical righteousness.',
        ],
        'L6_H10' => [
            'ml' => 'ആറാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് ജുഡീഷ്യറി, പോലീസ്, പ്രതിരോധം, മെഡിക്കൽ സർവ്വീസ്, അഡ്മിനിസ്ട്രേഷൻ എന്നിവയിൽ വലിയ നേട്ടങ്ങൾ നൽകുന്നു.',
            'en' => '6th lord in 10th House establishes successful authority in healthcare, defense, judiciary, audit, and labor administration.',
        ],
        'L6_H11' => [
            'ml' => 'ആറാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് മത്സരങ്ങളിലൂടെയും ബിസിനസ്സിലെ എതിരാളികളെ പരാജയപ്പെടുത്തിയും വലിയ ലാഭം കൊയ്യാൻ സഹായിക്കുന്നു.',
            'en' => '6th lord in 11th House converts intense competitive struggles into solid financial gains and expanded industry influence.',
        ],
        'L6_H12' => [
            'ml' => 'ആറാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിപരീത രാജയോഗമാണ്. വിദേശത്ത് ശത്രുദോഷങ്ങൾ ഇല്ലാതാവുകയും ആശുപത്രി അല്ലെങ്കിൽ നിയമകാര്യങ്ങളിലെ ചെലവുകൾ ലാഭകരമായി മാറുകയോ ചെയ്യും.',
            'en' => '6th lord in 12th House completes a Viparita Raja Yoga, nullifying hidden enemies and turning expenditures into institutional success.',
        ],

        // ---------------- HOUSE 7 LORD IN HOUSES 1 TO 12 ----------------
        'L7_H1' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് തികഞ്ഞ സ്നേഹവും അർപ്പണബോധവുമുള്ള ജീവിതപങ്കാളിയെ സമ്മാനിക്കുന്നു. പങ്കാളിയുടെ വരവോടെ ജാതകന്റെ ഭാഗ്യം ഇരട്ടിക്കും.',
            'en' => '7th lord in 1st House brings a devoted, accomplished spouse whose entrance elevates the native\'s social and financial status.',
        ],
        'L7_H2' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് വിവാഹശേഷം വലിയ സാമ്പത്തിക അഭിവൃദ്ധിയും, കുടുംബത്തിൽ ഐശ്വര്യവും സന്തോഷവും നിറയ്ക്കുന്നു.',
            'en' => '7th lord in 2nd House indicates wealth accretion through marriage, spouse\'s earning contribution, and joyful family life.',
        ],
        'L7_H3' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് പങ്കാളിയുടെ പ്രോത്സാഹനത്താൽ സ്വന്തം കഴിവുകൾ പുറത്തെടുക്കാനും യാത്രകളിലൂടെ നേട്ടമുണ്ടാക്കാനും സഹായിക്കുന്നു.',
            'en' => '7th lord in 3rd House fosters dynamic spousal collaboration, joint business enterprises, and rewarding travels.',
        ],
        'L7_H4' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് ദാമ്പത്യത്തിൽ ഗൃഹസൗഖ്യവും, സ്വന്തമായി വലിയ ഭവനവും വാഹനങ്ങളും, മാതൃതുല്യമായ സ്നേഹവും ഉറപ്പുവരുത്തുന്നു.',
            'en' => '7th lord in 4th House ensures deeply contented domestic life, fine residences, vehicles, and harmony between spouse and mother.',
        ],
        'L7_H5' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഉത്തമ പ്രണയസാഫല്യവും, സൽസ്വഭാവമുള്ള കുട്ടികളും, പരസ്പരം വിവേകത്തോടെ പെരുമാറുന്ന ദാമ്പത്യവും സമ്മാനിക്കുന്നു.',
            'en' => '7th lord in 5th House creates blissful romantic harmony, intelligent children, and noble spousal counsel.',
        ],
        'L7_H6' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് ദാമ്പത്യത്തിൽ പരസ്പര ധാരണയും തുറന്ന സംഭാഷണങ്ങളും ശീലമാക്കാൻ നിർദ്ദേശിക്കുന്നു. വിട്ടുവീഴ്ചകൾ സമാധാനം തരും.',
            'en' => '7th lord in 6th House counsels mutual forbearance, emotional transparency, and health mindfulness for enduring marital peace.',
        ],
        'L7_H7' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ ഏഴിൽ തന്നെ നിൽക്കുന്നത് മാളവ്യ യോഗ സമാനമായ ഉത്തമ ദാമ്പത്യസൗഖ്യമാണ്. പങ്കാളി സുന്ദരനും/സുന്ദരിയും സമൂഹത്തിൽ ഉന്നത മാന്യതയുള്ളയാളുമായിരിക്കും.',
            'en' => '7th lord in own 7th House creates splendid marital bliss, a dignified, attractive spouse, and successful business partnerships.',
        ],
        'L7_H8' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് ദാമ്പത്യജീവിതത്തിൽ ക്ഷമയും പരസ്പര വിശ്വാസവും കാത്തുസൂക്ഷിക്കാൻ ആവശ്യപ്പെടുന്നു. പങ്കാളിയിലൂടെ പൂർവ്വിക സ്വത്തുക്കൾ ലഭിക്കാം.',
            'en' => '7th lord in 8th House brings legacy or financial assets through the spouse\'s family, counseling patience and deep mutual trust.',
        ],
        'L7_H9' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് വിവാഹശേഷം രാജയോഗം പ്രധാനം ചെയ്യുന്ന സവിശേഷ സ്ഥാനമാണ്. പങ്കാളി അതീവ ധർമ്മിഷ്ഠനും/ധർമ്മിഷ്ഠയുമായിരിക്കും.',
            'en' => '7th lord in 9th House activates extraordinary good fortune after marriage, with a virtuous, spiritually inclined partner.',
        ],
        'L7_H10' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് പ്രൊഫഷണൽ രംഗത്ത് തിളങ്ങുന്ന പങ്കാളിയെയും, രണ്ടുപേരും ചേർന്നുള്ള സാമൂഹിക ഉന്നതിയെയും കാണിക്കുന്നു.',
            'en' => '7th lord in 10th House indicates a career-oriented, respected spouse who actively elevates mutual executive status.',
        ],
        'L7_H11' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് ദാമ്പത്യത്തിലൂടെ സർവ്വവിധ അഭീഷ്ടങ്ങളും സാധിക്കാനും വലിയ സാമ്പത്തിക നേട്ടങ്ങൾ കൈവരിക്കാനും കാരണമാകും.',
            'en' => '7th lord in 11th House realizes long-cherished ambitions through matrimonial harmony and lucrative business associations.',
        ],
        'L7_H12' => [
            'ml' => 'ഏഴാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശവാസത്തിനും, വിദേശത്തുനിന്നുള്ള പങ്കാളിക്കും, ഒരുമിച്ച് തീർത്ഥാടനങ്ങൾ നടത്തുന്നതിനും വഴിയൊരുക്കുന്നു.',
            'en' => '7th lord in 12th House favors foreign resettlement with the spouse, overseas business trade, and shared spiritual retreats.',
        ],

        // ---------------- HOUSE 8 LORD IN HOUSES 1 TO 12 ----------------
        'L8_H1' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് നിഗൂഢശാസ്ത്രങ്ങളിലും ആത്മീയ രഹസ്യങ്ങളിലും താല്പര്യം നൽകുന്നു. ആയുരാരോഗ്യത്തിനായി യോഗയും ഈശ്വരപ്രാർത്ഥനയും ഉത്തമം.',
            'en' => '8th lord in 1st House sparks profound esoteric curiosity, advising balanced health routines and spiritual sadhana for longevity.',
        ],
        'L8_H2' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് സാമ്പത്തിക കാര്യങ്ങളിൽ അപ്രതീക്ഷിത വ്യതിയാനങ്ങൾ കൊണ്ടുവരാമെങ്കിലും പൂർവ്വിക സ്വത്തുക്കൾക്ക് അനുകൂലമാണ്.',
            'en' => '8th lord in 2nd House brings sudden unearned wealth or inheritances, requiring disciplined household budgeting.',
        ],
        'L8_H3' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് രഹസ്യമായ അന്വേഷണപാടവവും, ഏതു പ്രതിസന്ധിയെയും ഭയപ്പെടാതെ നേരിടാനുള്ള ആന്തരിക കരുത്തും നൽകുന്നു.',
            'en' => '8th lord in 3rd House reinforces deep research capability and psychological fearlessness in overcoming challenging crises.',
        ],
        'L8_H4' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് പൂർവ്വിക ഗൃഹങ്ങളിലോ ഭൂമിയിലോ ഉള്ള അവകാശങ്ങൾ ലഭിക്കാൻ സഹായിക്കും. മനസ്സിന് ധ്യാനം ശാന്തി നൽകും.',
            'en' => '8th lord in 4th House connects to ancestral properties and secret archives, recommending meditation for domestic peace.',
        ],
        'L8_H5' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഗൂഢമന്ത്രങ്ങളിലും ജ്യോതിഷത്തിലും പ്രാവീണ്യം നൽകും. ഊഹക്കച്ചവടങ്ങളിൽ അതീവ ശ്രദ്ധ പുലർത്തണം.',
            'en' => '5th lord in 8th House confers profound occult intuition and analytical depth, advising prudent research before investments.',
        ],
        'L8_H6' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് സരള യോഗമാണ് (വിപരീത രാജയോഗം). ശത്രുക്കളുടെ തന്ത്രങ്ങൾ സ്വയം പൊളിയുകയും ആയുർബലം വർദ്ധിക്കുകയും ചെയ്യും.',
            'en' => '8th lord in 6th House creates Sarala Yoga (Viparita Raja Yoga), effortlessly dissipating adversaries and ensuring enduring longevity.',
        ],
        'L8_H7' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് പങ്കാളിയുടെ കുടുംബത്തിൽ നിന്നുള്ള ധനസഹായത്തിനും വിദേശ യാത്രകൾക്കും കാരണമാകും.',
            'en' => '8th lord in 7th House indicates legacy assets from the spouse\'s lineage and transformative international voyages.',
        ],
        'L8_H8' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ എട്ടിൽ തന്നെ നിൽക്കുന്നത് ദീർഘായുസ്സും, ഗൂഢശാസ്ത്ര സിദ്ധിയും, ആത്മീയമായ ഉണർവ്വും നൽകുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => '8th lord in own 8th House guarantees long life, deep yogic siddhi, impenetrable intuition, and successful research.',
        ],
        'L8_H9' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് പരമ്പരാഗത ആചാരങ്ങൾക്കപ്പുറം സാർവ്വലൗകിക ആത്മീയതയെക്കുറിച്ച് ചിന്തിക്കാൻ പ്രേരിപ്പിക്കുന്നു.',
            'en' => '8th lord in 9th House leads the native to explore profound universal metaphysics and transformative philosophical pilgrimages.',
        ],
        'L8_H10' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് ഗവേഷണം, രഹസ്യാന്വേഷണം, ഇൻഷുറൻസ്, ഖനനം, പുരാവസ്തു ശാസ്ത്രം എന്നിവയിൽ പ്രൊഫഷണൽ നേട്ടങ്ങൾ നൽകുന്നു.',
            'en' => '8th lord in 10th House establishes career excellence in forensic investigation, insurance, mining, archeology, or surgery.',
        ],
        'L8_H11' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് വിൽപത്രങ്ങൾ, നിക്ഷേപങ്ങൾ, അപ്രതീക്ഷിത ഉറവിടങ്ങൾ എന്നിവയിലൂടെ വലിയ ധനസമ്പാദനത്തിന് വഴിയൊരുക്കും.',
            'en' => '8th lord in 11th House unlocks unexpected financial revenues, legacies, and profitable returns from long-term assets.',
        ],
        'L8_H12' => [
            'ml' => 'എട്ടാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിമല യോഗമാണ് (വിപരീത രാജയോഗം). കടബാധ്യതകൾ ഇല്ലാതാവുകയും, ആത്മീയ മോക്ഷമാർഗ്ഗത്തിൽ ഉയർച്ച ലഭിക്കുകയും ചെയ്യും.',
            'en' => '8th lord in 12th House creates Vimala Yoga (Viparita Raja Yoga), liberating the native from financial distress and aiding spiritual liberation.',
        ],

        // ---------------- HOUSE 9 LORD IN HOUSES 1 TO 12 ----------------
        'L9_H1' => [
            'ml' => 'ഭാഗ്യാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ജന്മനാ ലഭിക്കുന്ന പരമോന്നത ഭാഗ്യമാണ്. ആജ്ഞാശക്തി, ഉന്നത വിദ്യാഭ്യാസം, ഈശ്വരകൃപ, സമൂഹത്തിൽ മാന്യത എന്നിവ എപ്പോഴും കൂടെയുണ്ടാകും.',
            'en' => '9th lord in 1st House is a supreme blessing, bestowing innate good fortune, philosophical wisdom, divine grace, and high social renown.',
        ],
        'L9_H2' => [
            'ml' => 'ഭാഗ്യാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് കുടുംബത്തിൽ അക്ഷയമായ ഐശ്വര്യവും, ധാർമ്മികമായ സംസാരരീതിയും, സാമ്പത്തിക സമൃദ്ധിയും ഉറപ്പുനൽകുന്നു.',
            'en' => '9th lord in 2nd House creates perpetual financial abundance, truthful speech, and a highly cultured family environment.',
        ],
        'L9_H3' => [
            'ml' => 'ഭാഗ്യാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് സ്വന്തം ധീരതയിലൂടെയും സഹോദര പിന്തുണയിലൂടെയും ഭാഗ്യം സ്വയം വെട്ടിപ്പിടിക്കാൻ സഹായിക്കുന്നു.',
            'en' => '9th lord in 3rd House links good fortune to personal enterprise, publications, courageous ventures, and fraternal goodwill.',
        ],
        'L9_H4' => [
            'ml' => 'ഭാഗ്യാധിപൻ നാലിൽ നിൽക്കുന്നത് ആഡംബര ഭവനങ്ങൾ, വാഹനങ്ങൾ, മാതൃസൗഖ്യം, ഉന്നത ബിരുദങ്ങൾ എന്നിവ നൽകുന്ന രാജയോഗമാണ്.',
            'en' => '9th lord in 4th House constitutes a magnificent Raja Yoga, granting palatial estates, luxury vehicles, maternal blessings, and degrees.',
        ],
        'L9_H5' => [
            'ml' => 'ഭാഗ്യാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ധർമ്മകർമ്മാധിപത്യ യോഗത്തിന് തുല്യമായ അനുഗ്രഹമാണ്. അസാധാരണ ബുദ്ധിസാമർത്ഥ്യവും, സൽസന്താനങ്ങളും, പൂർവ്വപുണ്യവും ലഭിക്കും.',
            'en' => '9th lord in 5th House creates a paramount Trikona Raja Yoga, activating brilliant creative intellect, noble progeny, and spiritual siddhi.',
        ],
        'L9_H6' => [
            'ml' => 'ഭാഗ്യാധിപൻ ആറിൽ നിൽക്കുന്നത് കഠിനാധ്വാനത്തിലൂടെയും സേവനപ്രവർത്തനങ്ങളിലൂടെയും ഭാഗ്യം കണ്ടെത്താൻ വഴിയൊരുക്കുന്നു.',
            'en' => '9th lord in 6th House manifests auspicious outcomes through dedicated service, public welfare work, and judicial fairness.',
        ],
        'L9_H7' => [
            'ml' => 'ഭാഗ്യാധിപൻ ഏഴിൽ നിൽക്കുന്നത് വിവാഹത്തോടെ ജീവിതത്തിൽ സകല ഭാഗ്യങ്ങളും പ്രകാശിക്കുന്നതിനും, വിദേശ യാത്രകൾക്കും കാരണമാകും.',
            'en' => '9th lord in 7th House unlocks splendid prosperity after marriage, bringing a noble spouse and fruitful international voyages.',
        ],
        'L9_H8' => [
            'ml' => 'ഭാഗ്യാധിപൻ എട്ടിൽ നിൽക്കുന്നത് ആത്മീയ പരിവർത്തനത്തിനും, പൂർവ്വിക രഹസ്യങ്ങൾ ഗ്രഹിക്കുന്നതിനും സഹായകരമാണ്. പിതൃകാര്യങ്ങൾ ഭക്തിയോടെ ചെയ്യണം.',
            'en' => '9th lord in 8th House stimulates profound metaphysical revelations, recommending devotion to ancestral rites and temple pujas.',
        ],
        'L9_H9' => [
            'ml' => 'ഭാഗ്യാധിപൻ ഒമ്പതിൽ തന്നെ നിൽക്കുന്നത് സാക്ഷാൽ ധർമ്മരാജ യോഗമാണ്. സൽക്കീർത്തി, പിതൃസൗഖ്യം, ഈശ്വരാനുഗ്രഹം, ലോകസഞ്ചാരം എന്നിവ സമ്മാനിക്കുന്നു.',
            'en' => '9th lord in own 9th House forms an exalted Dharma Raja Yoga, granting world travels, noble fame, paternal blessings, and divine protection.',
        ],
        'L9_H10' => [
            'ml' => 'ഭാഗ്യാധിപൻ പത്തിൽ നിൽക്കുന്നത് ധർമ്മകർമ്മാധിപതി രാജയോഗമാണ്. സമൂഹത്തിൽ പരമോന്നത പദവി, ഭരണാധികാരം, നിസ്തുലമായ തൊഴിൽവിജയം എന്നിവ നൽകുന്നു.',
            'en' => '9th lord in 10th House creates the celebrated Dharma-Karmadhipati Raja Yoga, conferring eminent governance, leadership, and professional renown.',
        ],
        'L9_H11' => [
            'ml' => 'ഭാഗ്യാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് ആഗ്രഹിച്ചതെല്ലാം നേടാനും, സ്ഥിരമായ വലിയ സാമ്പത്തിക വളർച്ച അനുഭവിക്കാനും വഴിയൊരുക്കുന്നു.',
            'en' => '9th lord in 11th House guarantees fulfillment of all high ambitions and brings continuous, abundant financial profits.',
        ],
        'L9_H12' => [
            'ml' => 'ഭാഗ്യാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശത്ത് വലിയ ഭാഗ്യവും, സൽക്കർമ്മങ്ങൾക്കായി ധനം വിനിയോഗിക്കാനുള്ള ഉദാരമനസ്സും നൽകുന്നു.',
            'en' => '9th lord in 12th House favors splendid fortunes in foreign lands and noble expenditure on spiritual sanctuaries and charities.',
        ],

        // ---------------- HOUSE 10 LORD IN HOUSES 1 TO 12 ----------------
        'L10_H1' => [
            'ml' => 'പത്താം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് സ്വന്തം കഴിവിനാൽ പേരും പ്രശസ്തിയും നേടുന്നവനും, സ്വതന്ത്രമായി കാര്യങ്ങൾ നടപ്പിലാക്കുന്ന നേതാവുമാക്കുന്നു.',
            'en' => '10th lord in 1st House creates an illustrious, self-made executive who commands authority and professional prestige through personal talent.',
        ],
        'L10_H2' => [
            'ml' => 'പത്താം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് തൊഴിലിലൂടെ വലിയ ധനം സമ്പാദിക്കാനും, വാണിജ്യരംഗത്തോ കുടുംബ ബിസിനസ്സിലോ ശോഭിക്കാനും സഹായിക്കുന്നു.',
            'en' => '10th lord in 2nd House brings prolific wealth through professional leadership, executive enterprise, or established commercial trade.',
        ],
        'L10_H3' => [
            'ml' => 'പത്താം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് മാധ്യമങ്ങൾ, വിവരസാങ്കേതികവിദ്യ, ട്രാവൽസ്, കായികരംഗം എന്നിവയിലൂടെ തൊഴിൽവിജയം ഉറപ്പുനൽകുന്നു.',
            'en' => '10th lord in 3rd House fosters distinguished success in media, publishing, logistics, communications, and enterprising ventures.',
        ],
        'L10_H4' => [
            'ml' => 'പത്താം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് റിയൽ എസ്റ്റേറ്റ്, വിദ്യാലയങ്ങൾ, കൃഷി, സർക്കാർ ഭരണരംഗം എന്നിവയിലൂടെ പ്രൊഫഷണൽ ഉന്നതി നൽകുന്നു.',
            'en' => '10th lord in 4th House links occupational achievement to institutional administration, education, properties, and community governance.',
        ],
        'L10_H5' => [
            'ml' => 'പത്താം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് മന്ത്രിപദവി, ഭരണോപദേശം, സാമ്പത്തിക നയരൂപീകരണം, സർഗ്ഗാത്മക നേതൃത്വം എന്നിവ സമ്മാനിക്കുന്നു.',
            'en' => '10th lord in 5th House confers elite advisory roles, policy-making, ministerial authority, and scholarly governance.',
        ],
        'L10_H6' => [
            'ml' => 'പത്താം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് ആരോഗ്യമേഖല, നിയമം, ഓഡിറ്റിംഗ്, തർക്കപരിഹാരം എന്നിവയിൽ മികച്ച നേട്ടങ്ങൾ പ്രദാനം ചെയ്യുന്നു.',
            'en' => '10th lord in 6th House excels in healthcare administration, legal arbitration, corporate auditing, and labor relations.',
        ],
        'L10_H7' => [
            'ml' => 'പത്താം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് വിദേശ വാണിജ്യം, പങ്കാളിത്ത ബിസിനസ്സ്, പൊതുജന സമ്പർക്കമുള്ള തൊഴിലുകൾ എന്നിവയിൽ വലിയ വിജയം നൽകുന്നു.',
            'en' => '10th lord in 7th House favors public diplomacy, overseas commercial contracts, partnerships, and high societal renown.',
        ],
        'L10_H8' => [
            'ml' => 'പത്താം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് ഗവേഷണം, രഹസ്യാന്വേഷണം, ഇൻഷുറൻസ്, ശസ്ത്രക്രിയ, ഖനന വ്യവസായം എന്നിവയിൽ മികച്ച ശോഭ നൽകുന്നു.',
            'en' => '10th lord in 8th House establishes careers in deep scientific research, forensic medicine, surgical science, or insurance management.',
        ],
        'L10_H9' => [
            'ml' => 'പത്താം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ധർമ്മകർമ്മാധിപതി രാജയോഗമാണ്. സമൂഹത്തിൽ ഉന്നതമായ ആദരവും, ഔദ്യോഗിക പദവികളും, നീതിപൂർവ്വമായ ഭരണവും നൽകുന്നു.',
            'en' => '10th lord in 9th House forms the celebrated Dharma-Karmadhipati Raja Yoga, endowing respected governance, ethical leadership, and high office.',
        ],
        'L10_H10' => [
            'ml' => 'പത്താം ഭാവാധിപൻ പത്തിൽ തന്നെ നിൽക്കുന്നത് സിംഹാസന യോഗമാണ്. സ്വന്തം തൊഴിൽമേഖലയിൽ ആരും വെല്ലുവിളിക്കാനാവാത്ത പരമോന്നത സ്ഥാനത്തെത്തും.',
            'en' => '10th lord in own 10th House creates Simhasana Yoga, ensuring undisputed executive command, peerless professional distinction, and fame.',
        ],
        'L10_H11' => [
            'ml' => 'പത്താം ഭാവാധിപൻ പതിനൊന്നിൽ നിൽക്കുന്നത് തൊഴിലിലൂടെ വൻ സാമ്പത്തിക ലാഭവും, ശക്തരായ വ്യക്തികളുമായി ഉന്നത സൗഹൃദവും ഉറപ്പുനൽകുന്നു.',
            'en' => '10th lord in 11th House converts professional authority into massive revenues, influential political circles, and sustained prosperity.',
        ],
        'L10_H12' => [
            'ml' => 'പത്താം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശ കമ്പനികൾ, എംബസികൾ, ആശുപത്രികൾ, ആത്മീയ സ്ഥാപനങ്ങൾ എന്നിവയിലൂടെ പ്രൊഫഷണൽ വിജയം നൽകുന്നു.',
            'en' => '10th lord in 12th House favors distinguished careers in multinational organizations, diplomatic missions, and philanthropic institutions.',
        ],

        // ---------------- HOUSE 11 LORD IN HOUSES 1 TO 12 ----------------
        'L11_H1' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് നിഷ്പ്രയാസം സാമ്പത്തിക നേട്ടങ്ങൾ കൈവരിക്കാനും, ജനസമ്മിതിയും സുഖസൗകര്യങ്ങളും ആസ്വദിക്കാനും സഹായിക്കുന്നു.',
            'en' => '11th lord in 1st House guarantees spontaneous financial prosperity, extensive social popularity, and luxurious personal comforts.',
        ],
        'L11_H2' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് ധനലാഭാധിപന്മാർ തമ്മിലുള്ള ശുഭയോഗമാണ്. കുടുംബത്തിൽ സദാ ധനസമൃദ്ധിയും സമാധാനവും ഉണ്ടാകും.',
            'en' => '11th lord in 2nd House forms an auspicious Dhana-Labha alliance, multiplying family wealth and expanding lucrative revenue streams.',
        ],
        'L11_H3' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് സഹോദരങ്ങളുടെ സഹായത്താലും സ്വന്തം പരിശ്രമത്താലും ആഗ്രഹങ്ങൾ നിറവേറ്റാൻ സഹായിക്കുന്നു.',
            'en' => '11th lord in 3rd House converts personal initiative, communications, and fraternal collaborations into profitable dividends.',
        ],
        'L11_H4' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് റിയൽ എസ്റ്റേറ്റ്, വാഹനങ്ങൾ, കാർഷികോല്പന്നങ്ങൾ എന്നിവയിലൂടെ വലിയ ലാഭം ഉറപ്പുവരുത്തുന്നു.',
            'en' => '11th lord in 4th House brings substantial gains from landed properties, agricultural holdings, luxury conveyances, and mother\'s lineage.',
        ],
        'L11_H5' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഓഹരി നിക്ഷേപങ്ങളിലൂടെയും മക്കളുടെ വിജയത്തിലൂടെയും വലിയ സാമ്പത്തിക അഭിവൃദ്ധി സമ്മാനിക്കുന്നു.',
            'en' => '11th lord in 5th House generates windfalls from strategic investments and brings immense joy and prestige through children.',
        ],
        'L11_H6' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് മത്സരങ്ങളിലൂടെയും ബിസിനസ്സിലെ വെല്ലുവിളികളെ അതിജീവിച്ചും ലാഭം കൊയ്യാൻ വഴിയൊരുക്കുന്നു.',
            'en' => '11th lord in 6th House yields lucrative gains by overcoming competitors and excelling in challenging service operations.',
        ],
        'L11_H7' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് ജീവിതപങ്കാളിയിലൂടെയോ പങ്കാളിത്ത ബിസിനസ്സിലൂടെയോ വൻ സാമ്പത്തിക മുന്നേറ്റം നൽകുന്നു.',
            'en' => '11th lord in 7th House unlocks expansive financial profits through marital alliances and flourishing cross-border partnerships.',
        ],
        'L11_H8' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് ഇൻഷുറൻസ്, പൂർവ്വിക സ്വത്തുക്കൾ, അവിചാരിത നിക്ഷേപങ്ങൾ എന്നിവയിലൂടെ അപ്രതീക്ഷിത ലാഭം നൽകും.',
            'en' => '11th lord in 8th House brings unexpected financial windfalls, insurance settlements, and inheritances from unexpected sources.',
        ],
        'L11_H9' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ഭാഗ്യാനുകൂല്യങ്ങളാലും ഈശ്വരകൃപയാലും സർവ്വകാര്യങ്ങളിലും ലാഭവും ഐശ്വര്യവും ഉറപ്പുവരുത്തുന്നു.',
            'en' => '11th lord in 9th House aligns noble fortune with financial success, making every righteous endeavor exceptionally profitable.',
        ],
        'L11_H10' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് തൊഴിൽപരമായ ഉന്നതിക്കൊപ്പം വലിയ സാമ്പത്തിക നേട്ടങ്ങളും ഭരണതലത്തിൽ സ്വാധീനവും സമ്മാനിക്കുന്നു.',
            'en' => '11th lord in 10th House merges executive authority with abundant revenues, expanding the native\'s public clout.',
        ],
        'L11_H11' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ പതിനൊന്നിൽ തന്നെ നിൽക്കുന്നത് മഹാ ലാഭയോഗമാണ്. ആഗ്രഹിച്ച കാര്യങ്ങൾ ഓരോന്നായി സാക്ഷാത്കരിക്കപ്പെടും.',
            'en' => '11th lord in own 11th House constitutes a supreme Labha Yoga, fulfilling long-held desires and multiplying wealth exponentially.',
        ],
        'L11_H12' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശത്തുനിന്നുള്ള വരുമാനത്തിനും, ജീവകാരുണ്യപരമായ വലിയ പദ്ധതികൾക്ക് ധനം ചെലവഴിക്കാനും കാരണമാകും.',
            'en' => '11th lord in 12th House indicates revenues from overseas territories and substantial expenditures directed toward philanthropic foundations.',
        ],

        // ---------------- HOUSE 12 LORD IN HOUSES 1 TO 12 ----------------
        'L12_H1' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് വിദേശവാസത്തിനും, ആത്മീയ ശാന്തതയ്ക്കും, ജീവകാരുണ്യ പ്രവർത്തനങ്ങളിൽ താല്പര്യത്തിനും വഴിയൊരുക്കുന്നു.',
            'en' => '12th lord in 1st House favors overseas residence, spiritual detachment, philanthropic inclinations, and contemplative serenity.',
        ],
        'L12_H2' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ രണ്ടിൽ നിൽക്കുന്നത് സാമ്പത്തിക കാര്യങ്ങളിൽ സൂക്ഷ്മത പാലിക്കാൻ ഓർമ്മിപ്പിക്കുന്നു. ധർമ്മസ്ഥാപനങ്ങൾക്കായി പണം ചെലവഴിക്കും.',
            'en' => '12th lord in 2nd House counsels prudent budgeting against impulsive spending, encouraging philanthropic contributions.',
        ],
        'L12_H3' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ മൂന്നിൽ നിൽക്കുന്നത് വിദേശങ്ങളിലേക്കുള്ള നിരന്തര യാത്രകൾക്കും, രചനകളിലൂടെ ആത്മീയ സന്ദേശങ്ങൾ പ്രചരിപ്പിക്കുന്നതിനും സഹായിക്കും.',
            'en' => '12th lord in 3rd House stimulates frequent international travel, research publications, and esoteric communications.',
        ],
        'L12_H4' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ നാലിൽ നിൽക്കുന്നത് ജന്മനാട്ടിൽ നിന്നകന്ന് വിദേശത്തോ ശാന്തമായ മറ്റൊരു സ്ഥലത്തോ വീട് വെച്ച് സമാധാനത്തോടെ ജീവിക്കാൻ കാരണമാകും.',
            'en' => '12th lord in 4th House encourages building peaceful residences in distant lands, foreign territories, or spiritual ashrams.',
        ],
        'L12_H5' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ അഞ്ചിൽ നിൽക്കുന്നത് ഉന്നതമായ ഈശ്വരചിന്ത, മന്ത്രോപാസന, വിദേശ സർവ്വകലാശാലകളിൽ ഉപരിപഠനം എന്നിവ നൽകുന്നു.',
            'en' => '12th lord in 5th House stimulates meditative contemplation, esoteric scholarship, and foreign university degrees.',
        ],
        'L12_H6' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ ആറിൽ നിൽക്കുന്നത് വിപരീത രാജയോഗമാണ്. കടങ്ങളും ശത്രുക്കളും അപ്രത്യക്ഷമാവുകയും വിദേശത്ത് മികച്ച നേട്ടങ്ങൾ കൈവരിക്കുകയും ചെയ്യും.',
            'en' => '12th lord in 6th House creates a Viparita Raja Yoga, dissolving debts and legal challenges while securing foreign victories.',
        ],
        'L12_H7' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ ഏഴിൽ നിൽക്കുന്നത് വിദേശപങ്കാളിക്കോ, വിദേശ വാണിജ്യത്തിനോ, പങ്കാളിയുമൊത്തുള്ള വിദേശവാസത്തിനോ അനുകൂലമാണ്.',
            'en' => '12th lord in 7th House favors international matrimonial unions, foreign trade, and peaceful overseas travels with spouse.',
        ],
        'L12_H8' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ എട്ടിൽ നിൽക്കുന്നത് സരള-വിമല വിപരീത രാജയോഗമാണ്. അപ്രതീക്ഷിതമായി ഭാഗ്യം തുണയ്ക്കുകയും ആയുർബലം വർദ്ധിക്കുകയും ചെയ്യും.',
            'en' => '12th lord in 8th House creates an auspicious Viparita Raja Yoga, shielding longevity and turning crises into spiritual breakthroughs.',
        ],
        'L12_H9' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ ഒമ്പതിൽ നിൽക്കുന്നത് ലോകത്തിലെ പ്രധാന തീർത്ഥാടന കേന്ദ്രങ്ങൾ സന്ദർശിക്കാനും വിദേശത്ത് ഉന്നത വിദ്യാഭ്യാസം നേടാനും സഹായിക്കുന്നു.',
            'en' => '12th lord in 9th House promotes global pilgrimages, foreign higher studies, and profound universal philanthropic projects.',
        ],
        'L12_H10' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ പത്തിൽ നിൽക്കുന്നത് മൾട്ടിനാഷണൽ കമ്പനികൾ, എംബസികൾ, ആശുപത്രികൾ, ആത്മീയ സ്ഥാപനങ്ങൾ എന്നിവയിലൂടെ തൊഴിൽവിജയം നൽകുന്നു.',
            'en' => '12th lord in 10th House establishes career prominence in multinational organizations, foreign diplomacy, hospitals, and charities.',
        ],
        'L12_H11' => [
            'ml' => 'പതിനൊന്നാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ നിൽക്കുന്നത് വിദേശ സ്രോതസ്സുകളിൽ നിന്നും ലാഭമുണ്ടാക്കാനും ആത്മീയ ആവശ്യങ്ങൾക്കായി ധനം വിനിയോഗിക്കാനും സഹായിക്കുന്നു.',
            'en' => '12th lord in 11th House channels income from foreign territories, channeling profits into spiritual and humanitarian foundations.',
        ],
        'L12_H12' => [
            'ml' => 'പന്ത്രണ്ടാം ഭാവാധിപൻ പന്ത്രണ്ടിൽ തന്നെ നിൽക്കുന്നത് വിമല യോഗമാണ്. മനസ്സിന് തികഞ്ഞ ശാന്തിയും, പരലോക മോക്ഷചിന്തയും, വിദേശത്ത് ഐശ്വര്യപൂർണ്ണമായ ജീവിതവും നൽകുന്നു.',
            'en' => '12th lord in own 12th House forms Vimala Yoga, granting mental tranquility, comfortable foreign domicile, and serene spiritual liberation.',
        ],
    ];

    /**
     * Master Dictionary of All 120 Planet-in-House Placements
     */
    public const PLANET_IN_HOUSE_PLACEMENTS = [
        // ---------------- SURYA (SUN) IN HOUSES 1 TO 12 ----------------
        'Su_H1' => [
            'ml' => 'സൂര്യൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ഉന്നതമായ ആത്മാഭിമാനവും, ആജ്ഞാശക്തിയും, നേതൃഗുണവും സമ്മാനിക്കുന്നു. ആരുടെയും മുന്നിൽ തലകുനിക്കാത്ത പ്രകൃതമായിരിക്കും. പിതൃസൗഖ്യവും ആത്മവിശ്വാസവും നൽകും.',
            'en' => 'Sun in 1st House confers radiant authority, natural executive presence, strong self-esteem, and commanding leadership.',
        ],
        'Su_H2' => [
            'ml' => 'സൂര്യൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ഗൗരവമുള്ളതും സത്യസന്ധവുമായ സംസാരരീതി സമ്മാനിക്കുന്നു. സ്വന്തം കർമ്മശേഷിയാൽ സമ്പത്ത് ആർജ്ജിക്കും.',
            'en' => 'Sun in 2nd House creates authoritative, candid speech and steady financial independence through personal merit.',
        ],
        'Su_H3' => [
            'ml' => 'സൂര്യൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് അസാമാന്യ ധൈര്യവും, സാഹസികതയും, ശത്രുജയവും സമ്മാനിക്കുന്നു. ചെയ്യുന്ന കാര്യങ്ങളിൽ വിജയം സുനിശ്ചിതമായിരിക്കും.',
            'en' => 'Sun in 3rd House endows extraordinary valor, dynamic enterprise, decisive victory over rivals, and self-confidence.',
        ],
        'Su_H4' => [
            'ml' => 'സൂര്യൻ നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് സമൂഹത്തിൽ ഉന്നത മാന്യതയും, പൂർവ്വിക ഭവനങ്ങളും, ഭരണതലത്തിലുള്ള സ്വാധീനവും നൽകുന്നു.',
            'en' => 'Sun in 4th House brings distinguished family repute, interest in ancestral heritage, and authoritative domestic presence.',
        ],
        'Su_H5' => [
            'ml' => 'സൂര്യൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് ബുദ്ധിസാമർത്ഥ്യവും, രാഷ്ട്രീയത്തിലും ഭരണത്തിലും താല്പര്യവും, ഉപദേശക യോഗ്യതയും നൽകുന്നു.',
            'en' => 'Sun in 5th House enhances creative intelligence, strategic advisory capability, and administrative acumen.',
        ],
        'Su_H6' => [
            'ml' => 'സൂര്യൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുഹന്താവായ രാജയോഗമാണ്. എതിരാളികളെ നിഷ്പ്രഭമാക്കാനും രോഗങ്ങളിൽ നിന്ന് വേഗത്തിൽ മുക്തി നേടാനും സഹായിക്കും.',
            'en' => 'Sun in 6th House forms a celebrated Upachaya Raja Yoga, completely subduing rivals, litigation, and physical debilities.',
        ],
        'Su_H7' => [
            'ml' => 'സൂര്യൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ആത്മാഭിമാനമുള്ള പങ്കാളിയെ നൽകുന്നു. ദാമ്പത്യത്തിൽ പരസ്പര ബഹുമാനത്തോടെ പെരുമാറുന്നത് വലിയ ശാന്തി നൽകും.',
            'en' => 'Sun in 7th House indicates a proud, principled spouse, advising mutual respect and equitable partnership.',
        ],
        'Su_H8' => [
            'ml' => 'സൂര്യൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ആത്മീയ രഹസ്യങ്ങളിലും പ്രകൃതിചികിത്സയിലും ഗവേഷണത്തിലും താല്പര്യം നൽകുന്നു.',
            'en' => 'Sun in 8th House sparks aptitude for esoteric metaphysics, transformative research, and deep inner fortitude.',
        ],
        'Su_H9' => [
            'ml' => 'സൂര്യൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് ഈശ്വരഭക്തി, പിതൃസ്നേഹം, ധർമ്മനിഷ്ഠ, ഉന്നത പദവികൾ എന്നിവ നൽകുന്ന ഭാഗ്യയോഗമാണ്.',
            'en' => 'Sun in 9th House confers profound devotion to truth, paternal blessings, ethical leadership, and spiritual renown.',
        ],
        'Su_H10' => [
            'ml' => 'സൂര്യൻ പത്താം ഭാവത്തിൽ ദിഗ്ബലവാനാണ്. ഭരണരംഗത്തോ ഉന്നത ഉദ്യോഗങ്ങളിലോ പരമോന്നത പദവിയും സൽക്കീർത്തിയും അധികാരവും നൽകുന്നു.',
            'en' => 'Sun in 10th House achieves maximum Digbala (directional strength), endowing preeminent executive command, government honors, and fame.',
        ],
        'Su_H11' => [
            'ml' => 'സൂര്യൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് വൻ സാമ്പത്തിക ലാഭവും, ഭരണാധികാരികളുമായുള്ള ഉന്നത സൗഹൃദവും, ആഗ്രഹസാഫല്യവും നൽകുന്നു.',
            'en' => 'Sun in 11th House guarantees massive income accruals, high-level political associations, and realization of lofty aspirations.',
        ],
        'Su_H12' => [
            'ml' => 'സൂര്യൻ പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്ത് പേരും പ്രശസ്തിയും നേടാനും ആത്മീയ നിഷ്ഠകളിൽ സമാധാനം കണ്ടെത്താനും വഴിയൊരുക്കുന്നു.',
            'en' => 'Sun in 12th House favors foreign assignments, diplomatic roles, and contemplative solitude for higher consciousness.',
        ],

        // ---------------- CHANDRA (MOON) IN HOUSES 1 TO 12 ----------------
        'Mo_H1' => [
            'ml' => 'ചന്ദ്രൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ആകർഷകമായ രൂപവും, കാരുണ്യമുള്ള മനസ്സും, ജനപ്രിയതയും നൽകുന്നു. ഭാവനാസമ്പന്നനും ശാന്തനുമായിരിക്കും.',
            'en' => 'Moon in 1st House bestows an attractive countenance, empathetic disposition, magnetic social charm, and fertile imagination.',
        ],
        'Mo_H2' => [
            'ml' => 'ചന്ദ്രൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് മാധുര്യമുള്ള സംസാരവും, ധനസമൃദ്ധിയും, കുടുംബത്തിൽ സ്നേഹവും സമാധാനവും സമ്മാനിക്കുന്നു.',
            'en' => 'Moon in 2nd House creates sweet, pleasant speech, steady financial prosperity, and deeply harmonious domestic life.',
        ],
        'Mo_H3' => [
            'ml' => 'ചന്ദ്രൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സഹോദരസ്നേഹവും, എഴുത്ത്, സംഗീതം, കല എന്നിവയിലുള്ള പ്രാവീണ്യവും നൽകുന്നു.',
            'en' => 'Moon in 3rd House fosters creative literary talents, fine artistic sensibilities, and cordial fraternal bonds.',
        ],
        'Mo_H4' => [
            'ml' => 'ചന്ദ്രൻ നാലാം ഭാവത്തിൽ ദിഗ്ബലവാനാണ്. മാതൃസൗഖ്യം, സ്വന്തമായി മനോഹരമായ വീട്, വാഹനങ്ങൾ, മനഃസ്സമാധാനം എന്നിവ നൽകുന്നു.',
            'en' => 'Moon in 4th House possesses full Digbala, ensuring rich maternal blessings, palatial home, luxury vehicles, and emotional serenity.',
        ],
        'Mo_H5' => [
            'ml' => 'ചന്ദ്രൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉയർന്ന ബുദ്ധികൂർമ്മതയും, സൽസന്താനങ്ങളും, സർഗ്ഗാത്മക പ്രതിഭയും നൽകുന്നു.',
            'en' => 'Moon in 5th House stimulates intuitive intelligence, virtuous progeny, dramatic flair, and devotional grace.',
        ],
        'Mo_H6' => [
            'ml' => 'ചന്ദ്രൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് സേവനരംഗത്തും ആരോഗ്യപരിപാലനത്തിലും താല്പര്യം നൽകുന്നു. സമീകൃതാഹാരം ശീലമാക്കണം.',
            'en' => 'Moon in 6th House excels in caregiving and healthcare administration, counseling regular emotional relaxation.',
        ],
        'Mo_H7' => [
            'ml' => 'ചന്ദ്രൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് സുന്ദരമായ ദാമ്പത്യവും, സ്നേഹസമ്പന്നയായ പങ്കാളിയെയും, ബിസിനസ്സിൽ മികച്ച ജനസമ്പർക്കവും നൽകുന്നു.',
            'en' => 'Moon in 7th House unites with a gentle, affectionate spouse, fostering flourishing public commerce and harmonious relations.',
        ],
        'Mo_H8' => [
            'ml' => 'ചന്ദ്രൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് അന്തർജ്ഞാനവും, യോഗ-ആത്മീയ ചിന്തകളും നൽകുന്നു. മനസ്സിന്റെ ധ്യാനത്തിന് ശിവഭജനം ഉത്തമമാണ്.',
            'en' => 'Moon in 8th House heightens intuitive perception and metaphysical depth, recommending meditation and devotion to Lord Shiva.',
        ],
        'Mo_H9' => [
            'ml' => 'ചന്ദ്രൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് തീർത്ഥാടനങ്ങളും, പിതൃസൗഖ്യവും, ഭാഗ്യാനുഭവങ്ങളും, ഉദാരമായ ദാനശീലവും സമ്മാനിക്കുന്നു.',
            'en' => 'Moon in 9th House inspires sacred travels, philanthropic generosity, virtuous ethics, and continuous good fortune.',
        ],
        'Mo_H10' => [
            'ml' => 'ചന്ദ്രൻ പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് പൊതുജനസമ്മിതിയും, സമൂഹത്തിൽ ആദരണീയമായ തൊഴിൽവിജയവും, നേതൃത്വവും സമ്മാനിക്കുന്നു.',
            'en' => 'Moon in 10th House brings widespread public popularity, successful executive authority, and respected community renown.',
        ],
        'Mo_H11' => [
            'ml' => 'ചന്ദ്രൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് വിശാലമായ സുഹൃദ്ബന്ധങ്ങളും, സ്ഥിരമായ സാമ്പത്തിക ലാഭവും, ആഗ്രഹസാഫല്യവും നൽകുന്നു.',
            'en' => 'Moon in 11th House guarantees expansive financial profits, influential female alliances, and fulfillment of heartfelt goals.',
        ],
        'Mo_H12' => [
            'ml' => 'ചന്ദ്രൻ പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശവാസത്തിനും, ഏകാന്തതയിലെ ആത്മീയ ശാന്തതയ്ക്കും, ജീവകാരുണ്യ പ്രവർത്തനങ്ങൾക്കും വഴിയൊരുക്കുന്നു.',
            'en' => 'Moon in 12th House favors foreign residence, peaceful spiritual contemplation, and selfless humanitarian endeavors.',
        ],

        // ---------------- KUJA (MARS) IN HOUSES 1 TO 12 ----------------
        'Ma_H1' => [
            'ml' => 'കുജൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് അസാമാന്യ ധൈര്യവും, പോരാട്ടവീര്യവും, ചുറുചുറുക്കും സമ്മാനിക്കുന്നു. മുൻകോപം നിയന്ത്രിച്ചാൽ വലിയ ഉയരങ്ങളിലെത്തും.',
            'en' => 'Mars in 1st House endows immense physical stamina, bold enterprising drive, and fearless initiative.',
        ],
        'Ma_H2' => [
            'ml' => 'കുജൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വ്യക്തവും ദൃഢവുമായ സംസാരരീതിയും, സാമ്പത്തിക കാര്യങ്ങളിൽ കർക്കശമായ നിയന്ത്രണവും നൽകുന്നു.',
            'en' => 'Mars in 2nd House creates forceful, decisive speech and energetic ambition to build tangible assets.',
        ],
        'Ma_H3' => [
            'ml' => 'കുജൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുഭയമില്ലാത്ത ധീരതയും, കായിക-സാങ്കേതിക രംഗങ്ങളിൽ മുന്നേറ്റവും സമ്മാനിക്കുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Mars in 3rd House is exceptionally strong, conferring peerless courage, technical prowess, and dominance over opposition.',
        ],
        'Ma_H4' => [
            'ml' => 'കുജൻ നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് ഭൂമി, റിയൽ എസ്റ്റേറ്റ്, നിർമ്മാണരംഗം എന്നിവയിൽ വലിയ ലാഭത്തിന് വഴിയൊരുക്കും. കുടുംബത്തിൽ ശാന്തത പാലിക്കണം.',
            'en' => 'Mars in 4th House brings substantial real estate gains and construction success, counseling patience in domestic matters.',
        ],
        'Ma_H5' => [
            'ml' => 'കുജൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് മൂർച്ചയേറിയ ബുദ്ധിസാമർത്ഥ്യവും, എൻജിനീയറിംഗ്-സാങ്കേതിക രംഗങ്ങളിൽ തിളക്കവും നൽകുന്നു.',
            'en' => 'Mars in 5th House sharpens technical intellect, engineering talent, and strategic competitive determination.',
        ],
        'Ma_H6' => [
            'ml' => 'കുജൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുഹന്താവായ പരമോന്നത രാജയോഗമാണ്. ഏതു വലിയ പ്രതിസന്ധികളെയും ധീരമായി തകർത്തെറിയും.',
            'en' => 'Mars in 6th House is hailed as a supreme Upachaya placement, utterly crushing adversaries and debt challenges.',
        ],
        'Ma_H7' => [
            'ml' => 'കുജൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ജീവിതപങ്കാളിക്ക് ഉശിരൻ വ്യക്തിത്വവും കാര്യപ്രാപ്തിയും സമ്മാനിക്കുന്നു. കുജദോഷ പരിഹാരങ്ങൾ ദാമ്പത്യത്തിൽ കൂടുതൽ മാധുര്യം നിറയ്ക്കും.',
            'en' => 'Mars in 7th House endows the spouse with dynamic energy and strong character, supported beautifully by classical marital pariharams.',
        ],
        'Ma_H8' => [
            'ml' => 'കുജൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് രഹസ്യ ശാസ്ത്രങ്ങളിലും സാങ്കേതിക ഗവേഷണങ്ങളിലും ഉന്നത ബുദ്ധി നൽകുന്നു. സുബ്രഹ്മണ്യ ഭജനം ഉത്തമമാണ്.',
            'en' => 'Mars in 8th House stimulates aptitude for technical research and occult mechanics, benefiting from devotion to Lord Subrahmanya.',
        ],
        'Ma_H9' => [
            'ml' => 'കുജൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് ധർമ്മസംരക്ഷണാഗ്രഹവും, ധീരമായ നിലപാടുകളും, വിദേശ യാത്രകളിലൂടെ നേട്ടങ്ങളും സമ്മാനിക്കുന്നു.',
            'en' => 'Mars in 9th House inspires fearless championing of righteousness, pioneering travels, and executive leadership.',
        ],
        'Ma_H10' => [
            'ml' => 'കുജൻ പത്താം ഭാവത്തിൽ കുലദീപക രാജയോഗവും ദിഗ്ബലവും നൽകുന്നു. പോലീസ്, സൈന്യം, എൻജിനീയറിംഗ്, ഭരണം എന്നിവയിൽ പരമോന്നത പദവിയിലെത്തും.',
            'en' => 'Mars in 10th House achieves peak Digbala and Kuladeepaka Yoga, conferring commanding authority in defense, engineering, surgery, and governance.',
        ],
        'Ma_H11' => [
            'ml' => 'കുജൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് ഭൂമി ഇടപാടുകളിലൂടെയും ബിസിനസ്സിലൂടെയും വൻ സാമ്പത്തിക ലാഭവും വലിയ വിജയങ്ങളും നൽകുന്നു.',
            'en' => 'Mars in 11th House generates prolific revenues from landed assets, commerce, and competitive enterprise.',
        ],
        'Ma_H12' => [
            'ml' => 'കുജൻ പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്ത് സാങ്കേതിക ജോലികൾക്കും വലിയ പദ്ധതികൾ നയിക്കുന്നതിനും അനുകൂലമാണ്.',
            'en' => 'Mars in 12th House favors international technical assignments, engineering contracts abroad, and focused spiritual discipline.',
        ],

        // ---------------- BUDHA (MERCURY) IN HOUSES 1 TO 12 ----------------
        'Me_H1' => [
            'ml' => 'ബുധൻ ലഗ്നത്തിൽ ദിഗ്ബലവാനാണ് (ഭദ്രയോഗ സാധ്യത). അസാധാരണ ബുദ്ധിസാമർത്ഥ്യം, വാക്ചാതുര്യം, സാഹിത്യ ഗണിത നൈപുണ്യം എന്നിവ സമ്മാനിക്കുന്നു.',
            'en' => 'Mercury in 1st House attains full Digbala (forming Bhadra Mahapurusha Yoga if in own/exalted sign), bestowing brilliant wit, eloquence, and intellectual dexterity.',
        ],
        'Me_H2' => [
            'ml' => 'ബുധൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് മനോഹരമായ സംസാരവും, ഗണിത-വാണിജ്യ സാമർത്ഥ്യത്താൽ വലിയ സാമ്പത്തിക വളർച്ചയും നൽകുന്നു.',
            'en' => 'Mercury in 2nd House creates articulate, persuasive speech and steady financial profits through commerce, writing, and accounting.',
        ],
        'Me_H3' => [
            'ml' => 'ബുധൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് എഴുത്ത്, മാധ്യമങ്ങൾ, വിവരസാങ്കേതികവിദ്യ എന്നിവയിൽ അസാധാരണ പ്രാവീണ്യവും സഹോദരസ്നേഹവും സമ്മാനിക്കുന്നു.',
            'en' => 'Mercury in 3rd House fosters creative journalism, publishing, software prowess, and close camaraderie with siblings.',
        ],
        'Me_H4' => [
            'ml' => 'ബുധൻ നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉന്നതവിദ്യാഭ്യാസം, ബഹുഭാഷാ പാണ്ഡിത്യം, സുഖസൗകര്യങ്ങൾ, മനഃസ്സമാധാനം എന്നിവ ഉറപ്പുനൽകുന്നു.',
            'en' => 'Mercury in 4th House ensures scholarly academic degrees, multilingual versatility, domestic comfort, and maternal love.',
        ],
        'Me_H5' => [
            'ml' => 'ബുധൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് അപാരമായ ക്രിയാത്മക ബുദ്ധിയും, ആലോചനാ ശേഷിയും, സാമ്പത്തിക നയരൂപീകരണ മികവും സമ്മാനിക്കുന്നു.',
            'en' => 'Mercury in 5th House activates dazzling creative intelligence, strategic advisory capability, and speculative financial success.',
        ],
        'Me_H6' => [
            'ml' => 'ബുധൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് മത്സരപരീക്ഷകളിലും വാദപ്രതിവാദങ്ങളിലും എതിരാളികളെ ബുദ്ധിപൂർവ്വം പരാജയപ്പെടുത്താൻ സഹായിക്കുന്നു.',
            'en' => 'Mercury in 6th House excels in debate, competitive examinations, audit, and resolving disputes via rational diplomacy.',
        ],
        'Me_H7' => [
            'ml' => 'ബുധൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ബുദ്ധിമതിയായ ജീവിതപങ്കാളിയെയും, വാണിജ്യരംഗത്ത് വിശ്വസ്തരായ പങ്കാളികളെയും ഉറപ്പുനൽകുന്നു.',
            'en' => 'Mercury in 7th House unites with an educated, charming, witty spouse, promoting profitable commercial partnerships.',
        ],
        'Me_H8' => [
            'ml' => 'ബുധൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ദീർഘായുസ്സും, ഗൂഢശാസ്ത്രങ്ങളിലും സങ്കീർണ്ണമായ ഡാറ്റാ അപഗ്രഥനത്തിലും അസാധാരണ വൈദഗ്ദ്ധ്യവും നൽകുന്നു.',
            'en' => 'Mercury in 8th House confers long life, aptitude for data analytics, scientific research, and deep occult insight.',
        ],
        'Me_H9' => [
            'ml' => 'ബുധൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉന്നതവിദ്യാഭ്യാസവും, തത്ത്വചിന്താ താല്പര്യവും, ധാർമ്മികമായ സാഹിത്യരചനകളും സമ്മാനിക്കുന്ന ഭാഗ്യസ്ഥാനമാണ്.',
            'en' => 'Mercury in 9th House inspires scholarly higher learning, philosophical writing, and fortunate academic journeys.',
        ],
        'Me_H10' => [
            'ml' => 'ബുധൻ പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് അക്കൗണ്ടിംഗ്, വിവരസാങ്കേതികവിദ്യ, ബാങ്കിംഗ്, പത്രപ്രവർത്തനം, വ്യാപാരം എന്നിവയിൽ പരമോന്നത വിജയം നൽകുന്നു.',
            'en' => 'Mercury in 10th House establishes distinguished careers in IT, journalism, banking, publishing, and international trade.',
        ],
        'Me_H11' => [
            'ml' => 'ബുധൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സ്വന്തം ബുദ്ധിസാമർത്ഥ്യത്താൽ വൻ സാമ്പത്തിക ലാഭവും ഉന്നത സൗഹൃദങ്ങളും നേടാൻ വഴിയൊരുക്കുന്നു.',
            'en' => 'Mercury in 11th House converts intellectual enterprises and commercial acumen into manifold financial profits.',
        ],
        'Me_H12' => [
            'ml' => 'ബുധൻ പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശ സർവ്വകലാശാലകളിലെ പഠനത്തിനും, ആത്മീയ ഗ്രന്ഥരചനയ്ക്കും, നിശബ്ദ ഗവേഷണത്തിനും അനുകൂലമാണ്.',
            'en' => 'Mercury in 12th House favors foreign education, research publications, and serene intellectual contemplation.',
        ],

        // ---------------- GURU (JUPITER) IN HOUSES 1 TO 12 ----------------
        'Ju_H1' => [
            'ml' => 'വ്യാഴം ലഗ്നത്തിൽ നിൽക്കുന്നത് (ഹംസയോഗ സാധ്യത) ആയിരം ദോഷങ്ങളെ ശമിപ്പിക്കുന്ന പരമോന്നത ദൈവാനുഗ്രഹമാണ്. വിശാലഹൃദയം, ജ്ഞാനം, സൽക്കീർത്തി എന്നിവ നൽകുന്നു.',
            'en' => 'Jupiter in 1st House attains peak Digbala (forming Hamsa Mahapurusha Yoga in Kendra/own/exaltation), conferring divine grace, magnanimous wisdom, and peerless moral stature.',
        ],
        'Ju_H2' => [
            'ml' => 'വ്യാഴം രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വാക്ചാതുര്യവും, അക്ഷയമായ സമ്പത്തും, സരസ്വതീ കടാക്ഷവും, സംതൃപ്തമായ കുടുംബജീവിതവും നൽകുന്നു.',
            'en' => 'Jupiter in 2nd House bestows truthful eloquence, steady wealth accumulation, refined family heritage, and scholarship.',
        ],
        'Ju_H3' => [
            'ml' => 'വ്യാഴം മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സഹോദരസ്നേഹവും, ഉയർന്ന ആശയവിനിമയ മികവും, ധർമ്മനിഷ്ഠമായ സംരംഭങ്ങളും പ്രദാനം ചെയ്യുന്നു.',
            'en' => 'Jupiter in 3rd House brings dignified communication, philosophical writing, and honorable fraternal relationships.',
        ],
        'Ju_H4' => [
            'ml' => 'വ്യാഴം നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് മാതൃസൗഖ്യം, സ്വന്തമായി മനോഹരമായ വീട്, ആഡംബര വാഹനങ്ങൾ, മനഃസ്സമാധാനം എന്നിവ നൽകുന്ന മഹാഭാഗ്യമാണ്.',
            'en' => 'Jupiter in 4th House ensures profound domestic peace, palatial real estate, fine vehicles, and blessings of learned elders.',
        ],
        'Ju_H5' => [
            'ml' => 'വ്യാഴം അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉന്നത വിജ്ഞാനവും, മന്ത്രിസമാനമായ ഉപദേശക യോഗ്യതയും, സൽസന്താനഭാഗ്യവും സമ്മാനിക്കുന്നു.',
            'en' => 'Jupiter in 5th House creates brilliant creative intellect, noble prosperous progeny, and high advisory status.',
        ],
        'Ju_H6' => [
            'ml' => 'വ്യാഴം ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുക്കളെ സൗമ്യതയാലും വിവേകത്താലും മിത്രങ്ങളാക്കി മാറ്റാനും രോഗവിമുക്തി നേടാനും സഹായിക്കുന്നു.',
            'en' => 'Jupiter in 6th House resolves disputes through ethical diplomacy and protects health through balanced living.',
        ],
        'Ju_H7' => [
            'ml' => 'വ്യാഴം ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉന്നത കുലജാതയും സദ്ഗുണസമ്പന്നയുമായ പങ്കാളിയെയും, മാതൃകാപരമായ ദാമ്പത്യ സൗഖ്യവും നൽകുന്നു.',
            'en' => 'Jupiter in 7th House unites with a virtuous, cultured, respected spouse, ensuring enduring marital happiness.',
        ],
        'Ju_H8' => [
            'ml' => 'വ്യാഴം എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ദീർഘായുസ്സും, ഗൂഢശാസ്ത്രങ്ങളിലും ആത്മീയ തത്ത്വങ്ങളിലും അഗാധമായ വിജ്ഞാനവും നൽകുന്നു.',
            'en' => 'Jupiter in 8th House confers long life, peace of mind, esoteric wisdom, and sudden unearned financial legacies.',
        ],
        'Ju_H9' => [
            'ml' => 'വ്യാഴം ഒമ്പതാം ഭാവത്തിൽ സ്വക്ഷേത്രബലത്തോടെ നിൽക്കുന്നത് സാക്ഷാൽ ധർമ്മാധിപത്യമാണ്. സകലവിധ ഭാഗ്യങ്ങളും ഈശ്വരാനുഗ്രഹവും ലഭിക്കും.',
            'en' => 'Jupiter in 9th House is the ultimate karaka placement, showering boundless good fortune, spiritual wisdom, and noble renown.',
        ],
        'Ju_H10' => [
            'ml' => 'വ്യാഴം പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് നീതിന്യായം, വിദ്യാഭ്യാസം, ധനകാര്യം, ഭരണം എന്നിവയിൽ പരമോന്നത പദവികളും ആദരവും ഉറപ്പുവരുത്തുന്നു.',
            'en' => 'Jupiter in 10th House establishes preeminent careers in jurisprudence, higher education, finance, and community leadership.',
        ],
        'Ju_H11' => [
            'ml' => 'വ്യാഴം പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സർവ്വവിധ ആഗ്രഹസാഫല്യവും, വൻ സാമ്പത്തിക ലാഭവും, ഉന്നത വ്യക്തികളുമായി ആത്മബന്ധവും നൽകുന്നു.',
            'en' => 'Jupiter in 11th House guarantees fulfillment of all high goals, continuous financial abundance, and noble elder mentors.',
        ],
        'Ju_H12' => [
            'ml' => 'വ്യാഴം പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്ത് മാന്യമായ ജീവിതവും, ജീവകാരുണ്യപരമായ വലിയ പ്രവർത്തനങ്ങളും, മോക്ഷപ്രാപ്തിയും നൽകുന്നു.',
            'en' => 'Jupiter in 12th House favors dignified life in foreign lands, spiritual philanthropy, and serene detachment.',
        ],

        // ---------------- SHUKRA (VENUS) IN HOUSES 1 TO 12 ----------------
        'Ve_H1' => [
            'ml' => 'ശുക്രൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് (മാളവ്യയോഗ സാധ്യത) അതീവ സുന്ദരമായ രൂപവും, ആകർഷകമായ വ്യക്തിത്വവും, കലാവാസനയും നൽകുന്നു.',
            'en' => 'Venus in 1st House bestows striking aesthetic beauty, personal charm, artistic talent, and magnetic charisma.',
        ],
        'Ve_H2' => [
            'ml' => 'ശുക്രൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് മധുരമായ സംസാരവും, വസ്ത്രാഭരണാദി സമ്പത്തും, ആഡംബരപൂർണ്ണമായ കുടുംബജീവിതവും നൽകുന്നു.',
            'en' => 'Venus in 2nd House creates charming speech, abundant liquid wealth, fine jewelry, and joyful domestic prosperity.',
        ],
        'Ve_H3' => [
            'ml' => 'ശുക്രൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സംഗീതം, നാടകം, ഫാഷൻ, ഡിസൈനിംഗ് എന്നിവയിൽ അപാരമായ സർഗ്ഗാത്മകത സമ്മാനിക്കുന്നു.',
            'en' => 'Venus in 3rd House fosters creative genius in music, dramatic arts, fashion, and media communications.',
        ],
        'Ve_H4' => [
            'ml' => 'ശുക്രൻ നാലാം ഭാവത്തിൽ ദിഗ്ബലവാനാണ്. ആഡംബര ഭവനങ്ങൾ, ഏറ്റവും പുതിയ വാഹനങ്ങൾ, മാതൃസ്നേഹം, സകല ഭൗതിക സുഖങ്ങളും നൽകുന്നു.',
            'en' => 'Venus in 4th House attains full Digbala, conferring palatial residences, luxury vehicles, maternal love, and aesthetic comfort.',
        ],
        'Ve_H5' => [
            'ml' => 'ശുക്രൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് റൊമാന്റിക് സൗന്ദര്യവും, ഉന്നതമായ കലാവാസനയും, മക്കളിലൂടെ വലിയ സന്തോഷവും നൽകുന്നു.',
            'en' => 'Venus in 5th House creates refined aesthetic creativity, romantic fulfillment, artistic distinction, and beautiful progeny.',
        ],
        'Ve_H6' => [
            'ml' => 'ശുക്രൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് സമാധാനപരമായ നയതന്ത്രത്തിലൂടെ കാര്യങ്ങൾ സാധിക്കാനും ഫാഷൻ-സൗന്ദര്യ മേഖലയിൽ നേട്ടമുണ്ടാക്കാനും സഹായിക്കും.',
            'en' => 'Venus in 6th House resolves challenges through polite diplomacy, excelling in beauty, healthcare, and hospitality sectors.',
        ],
        'Ve_H7' => [
            'ml' => 'ശുക്രൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് അതീവ സുന്ദരിയായ/സുന്ദരനായ പങ്കാളിയെയും, പരസ്പര സ്നേഹം നിറഞ്ഞ ദാമ്പത്യവും ഉറപ്പുനൽകുന്നു.',
            'en' => 'Venus in 7th House unites with an affectionate, attractive, accomplished spouse, ensuring deep marital fulfillment.',
        ],
        'Ve_H8' => [
            'ml' => 'ശുക്രൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് പങ്കാളിയിലൂടെ വലിയ സ്വത്തുക്കളും ആഡംബരങ്ങളും അപ്രതീക്ഷിതമായി ലഭിക്കാൻ കാരണമാകും.',
            'en' => 'Venus in 8th House brings substantial legacies, spousal assets, and unexpected material windfalls.',
        ],
        'Ve_H9' => [
            'ml' => 'ശുക്രൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് ഭാഗ്യവതിയായ പങ്കാളിയെയും, വിദേശ യാത്രകളിലൂടെ സന്തോഷവും സമ്പത്തും സമ്മാനിക്കുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Venus in 9th House confers fortunate marriage, luxury overseas voyages, and righteous philanthropic prosperity.',
        ],
        'Ve_H10' => [
            'ml' => 'ശുക്രൻ പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് സിനിമ, കല, സംഗീതം, ഫാഷൻ, ആഡംബര ഉല്പന്നങ്ങൾ, വിനോദസഞ്ചാരം എന്നിവയിൽ വലിയ വിജയം നൽകുന്നു.',
            'en' => 'Venus in 10th House establishes illustrious careers in media, creative arts, hospitality, fashion, and luxury trade.',
        ],
        'Ve_H11' => [
            'ml' => 'ശുക്രൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് കലാപരമായ സംരംഭങ്ങളിലൂടെ വൻ സാമ്പത്തിക ലാഭവും, വിശാലമായ സുഹൃദ് സദസ്സും നൽകുന്നു.',
            'en' => 'Venus in 11th House generates manifold financial revenues from artistic and commercial ventures, with influential female allies.',
        ],
        'Ve_H12' => [
            'ml' => 'ശുക്രൻ പന്ത്രണ്ടാം ഭാവത്തിൽ അതീവ ബലവാനാണ് (ഉച്ചസമാന ഫലം). സകലവിധ ശയനാദി സുഖങ്ങളും, വിദേശ ആഡംബര ജീവിതവും സമ്മാനിക്കുന്നു.',
            'en' => 'Venus in 12th House is exceptionally auspicious, conferring luxurious comforts, foreign prosperity, and peaceful aesthetic contentment.',
        ],

        // ---------------- SHANI (SATURN) IN HOUSES 1 TO 12 ----------------
        'Sa_H1' => [
            'ml' => 'ശനി ലഗ്നത്തിൽ നിൽക്കുന്നത് (ശശയോഗ സാധ്യത) ഗൗരവമുള്ള വ്യക്തിത്വവും, കഠിനാധ്വാനവും, പക്വതയും നൽകുന്നു. പടിപടിയായി ഉന്നതിയിലെത്തും.',
            'en' => 'Saturn in 1st House (forming Sasa Mahapurusha Yoga in Kendra/own/exaltation) fosters mature discipline, endurance, and incremental lasting success.',
        ],
        'Sa_H2' => [
            'ml' => 'ശനി രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് സാമ്പത്തിക കാര്യങ്ങളിൽ അച്ചടക്കവും മിതവ്യയവും നൽകുന്നു. പക്വമായ സംസാരരീതിയായിരിക്കും.',
            'en' => 'Saturn in 2nd House creates measured, thoughtful speech and patient, steady accumulation of long-term assets.',
        ],
        'Sa_H3' => [
            'ml' => 'ശനി മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് അസാധാരണ ഇച്ഛാശക്തിയും, പ്രതിബന്ധങ്ങളെ തകർക്കാനുള്ള മനക്കരുത്തും നൽകുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Saturn in 3rd House is hailed as an ideal Upachaya placement, bestowing invincible stamina, courage, and victory over adversaries.',
        ],
        'Sa_H4' => [
            'ml' => 'ശനി നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് പൂർവ്വിക ഗൃഹങ്ങളും ഭൂമിയും നേടാൻ സഹായിക്കും. കുടുംബത്തിൽ പരമ്പരാഗത ചിട്ടകൾ പാലിക്കാൻ ഇഷ്ടപ്പെടും.',
            'en' => 'Saturn in 4th House connects to ancestral properties and traditional roots, counseling patience in domestic matters.',
        ],
        'Sa_H5' => [
            'ml' => 'ശനി അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് ഗഹനമായ ഗവേഷണ ബുദ്ധിയും, ചരിത്രം, തത്ത്വശാസ്ത്രം എന്നിവയിൽ അഗാധമായ പാണ്ഡിത്യവും നൽകുന്നു.',
            'en' => 'Saturn in 5th House deepens analytical concentration, philosophical scholarship, and methodical problem-solving.',
        ],
        'Sa_H6' => [
            'ml' => 'ശനി ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുഹന്താവായ രാജയോഗമാണ്. കടങ്ങളെയും ശത്രുക്കളെയും നിഷ്പ്രയാസം കീഴടക്കി വിജയം കൈവരിക്കും.',
            'en' => 'Saturn in 6th House forms a celebrated Upachaya Raja Yoga, completely subduing rivals, litigation, and debts through patient resilience.',
        ],
        'Sa_H7' => [
            'ml' => 'ശനി ഏഴാം ഭാവത്തിൽ ദിഗ്ബലവാനാണ് (ശശയോഗ സാധ്യത). പക്വതയും ഉത്തരവാദിത്തവുമുള്ള പങ്കാളിയെയും, സുസ്ഥിരമായ ദാമ്പത്യവും സമ്മാനിക്കുന്നു.',
            'en' => 'Saturn in 7th House achieves full Digbala, uniting with a mature, dutiful, loyal spouse and anchoring stable partnerships.',
        ],
        'Sa_H8' => [
            'ml' => 'ശനി എട്ടാം ഭാവത്തിൽ കാരകസ്ഥാനത്താണ്. അത്യുത്തമമായ ദീർഘായുസ്സും, ഗൂഢവിദ്യകളിൽ വൈദഗ്ദ്ധ്യവും, പെട്ടെന്നുള്ള തടസ്സങ്ങളെ അതിജീവിക്കാനുള്ള കരുത്തും നൽകുന്നു.',
            'en' => 'Saturn in 8th House is the ideal karaka placement, ensuring exceptional longevity, deep stamina, and mastery over crises.',
        ],
        'Sa_H9' => [
            'ml' => 'ശനി ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് പാരമ്പര്യ ആചാരങ്ങളിലും തത്ത്വചിന്തയിലും അതീവ താല്പര്യം നൽകുന്നു. ജീവിതത്തിന്റെ രണ്ടാം പകുതിയിൽ ഭാഗ്യം പ്രകാശിക്കും.',
            'en' => 'Saturn in 9th House inspires traditional ethics, solemn pilgrimages, and steady karmic good fortune unfolding with maturity.',
        ],
        'Sa_H10' => [
            'ml' => 'ശനി പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് കഠിനാധ്വാനത്തിലൂടെ ഉന്നത പദവികൾ നേടാനും, ജനനായകനാവാനും, സുസ്ഥിരമായ തൊഴിൽവിജയം കൈവരിക്കാനും വഴിയൊരുക്കുന്നു.',
            'en' => 'Saturn in 10th House creates renowned community leaders, industrial architects, and enduring executive statesmen through tireless labor.',
        ],
        'Sa_H11' => [
            'ml' => 'ശനി പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സ്ഥിരവും ശാശ്വതവുമായ സാമ്പത്തിക ലാഭവും, ശക്തമായ സംഘടനകളുടെ നേതൃത്വവും ഉറപ്പുനൽകുന്നു.',
            'en' => 'Saturn in 11th House generates prolific, steady wealth, wide organizational networks, and realization of long-term ambitions.',
        ],
        'Sa_H12' => [
            'ml' => 'ശനി പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്ത് സുസ്ഥിരമായ തൊഴിലിനും, ഏകാന്ത ആത്മീയ സാധനകൾക്കും, നിസ്വാർത്ഥ സേവനങ്ങൾക്കും അനുകൂലമാണ്.',
            'en' => 'Saturn in 12th House favors disciplined foreign engagements, solitary meditation, and selfless charitable administration.',
        ],

        // ---------------- RAHU IN HOUSES 1 TO 12 ----------------
        'Ra_H1' => [
            'ml' => 'രാഹു ലഗ്നത്തിൽ നിൽക്കുന്നത് സവിശേഷമായ കാന്തിയും, പുതിയ കാലത്തിന്റെ സാങ്കേതികവിദ്യകളിൽ താല്പര്യവും, അസാധാരണ ലക്ഷ്യബോധവും നൽകുന്നു.',
            'en' => 'Rahu in 1st House endows magnetic charisma, innovative ambition, affinity for modern technology, and original thinking.',
        ],
        'Ra_H2' => [
            'ml' => 'രാഹു രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശബന്ധങ്ങളിലൂടെയോ പുതിയ ബിസിനസ്സ് രീതികളിലൂടെയോ വലിയ സാമ്പത്തിക വളർച്ചയ്ക്ക് വഴിയൊരുക്കുന്നു.',
            'en' => 'Rahu in 2nd House brings unconventional financial windfalls through cross-border trade, media, and novel commercial ventures.',
        ],
        'Ra_H3' => [
            'ml' => 'രാഹു മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുഭയമില്ലാത്ത ധീരതയും, മാധ്യമങ്ങൾ, എഴുത്ത്, ഇന്റർനെറ്റ് എന്നിവയിലൂടെ വൻ വിജയവും നൽകുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Rahu in 3rd House is hailed as a supreme Upachaya placement, conferring bold audacity, media success, and triumph over rivals.',
        ],
        'Ra_H4' => [
            'ml' => 'രാഹു നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്തോ ജന്മനാട്ടിൽ നിന്നകന്നോ ആധുനിക സൗകര്യങ്ങളുള്ള വലിയ വീട് സ്വന്തമാക്കാൻ സഹായിക്കും.',
            'en' => 'Rahu in 4th House favors acquiring modern, high-tech properties in metropolitan centers or overseas territories.',
        ],
        'Ra_H5' => [
            'ml' => 'രാഹു അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് സോഫ്റ്റ്‌വെയർ, സിനിമ, ഊഹക്കച്ചവടം, ആധുനിക ശാസ്ത്രം എന്നിവയിൽ അപാരമായ ബുദ്ധിവികാസം നൽകുന്നു.',
            'en' => 'Rahu in 5th House stimulates out-of-the-box creative intelligence, software programming, cinema, and speculative acumen.',
        ],
        'Ra_H6' => [
            'ml' => 'രാഹു ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് അജയ്യനായ ശത്രുജയവും, ഏതു മത്സരപരീക്ഷയിലും മുന്നിലെത്താനുള്ള അസാധാരണ കഴിവുമുണ്ട്.',
            'en' => 'Rahu in 6th House is an invincible Upachaya placement, crushing competitors and navigating institutional litigation with ease.',
        ],
        'Ra_H7' => [
            'ml' => 'രാഹു ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശ സംസ്കാരവുമായി ബന്ധപ്പെട്ടതോ പുരോഗമന ചിന്താഗതിയുള്ളതോ ആയ പങ്കാളിയെ സമ്മാനിക്കുന്നു.',
            'en' => 'Rahu in 7th House indicates a progressive, dynamic spouse or success in international cross-cultural partnerships.',
        ],
        'Ra_H8' => [
            'ml' => 'രാഹു എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് നിഗൂഢശാസ്ത്രങ്ങളിലും ഡാറ്റാ മൈനിംഗിലും ആഴത്തിലുള്ള ഗവേഷണത്തിലും പ്രത്യേക താല്പര്യം നൽകും.',
            'en' => 'Rahu in 8th House sparks aptitude for occult investigation, forensic data forensics, and sudden transformative opportunities.',
        ],
        'Ra_H9' => [
            'ml' => 'രാഹു ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശയാത്രകൾക്കും, പരമ്പരാഗത അതിരുകൾ കടന്നുള്ള സാർവ്വലൗകിക ആത്മീയ അന്വേഷണങ്ങൾക്കും അനുകൂലമാണ്.',
            'en' => 'Rahu in 9th House inspires international pilgrimages, foreign education, and progressive universal philosophy.',
        ],
        'Ra_H10' => [
            'ml' => 'രാഹു പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് കരിയറിൽ അപ്രതീക്ഷിതമായ വലിയ ഉയരങ്ങളിലെത്താനും, വിദേശ കമ്പനികളിലോ രാഷ്ട്രീയത്തിലോ തിളങ്ങാനും സഹായിക്കുന്നു.',
            'en' => 'Rahu in 10th House propels meteoric career ascents in multinational corporations, politics, aviation, and digital media.',
        ],
        'Ra_H11' => [
            'ml' => 'രാഹു പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് സർവ്വവിധ ആഗ്രഹസാഫല്യവും, അപ്രതീക്ഷിതമായ വലിയ സാമ്പത്തിക ലാഭങ്ങളും നൽകുന്ന പരമോന്നത സ്ഥാനമാണ്.',
            'en' => 'Rahu in 11th House is one of the most lucrative placements in astrology, unlocking unexpected massive financial windfalls.',
        ],
        'Ra_H12' => [
            'ml' => 'രാഹു പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വിദേശത്ത് സ്ഥിരതാമസത്തിനും, വിദേശത്തുനിന്നുള്ള ധനാഗമത്തിനും, ആധുനിക ആത്മീയതയ്ക്കും വഴിയൊരുക്കുന്നു.',
            'en' => 'Rahu in 12th House favors permanent foreign settlement, global trade revenue, and exploratory metaphysical studies.',
        ],

        // ---------------- KETU IN HOUSES 1 TO 12 ----------------
        'Ke_H1' => [
            'ml' => 'കേതു ലഗ്നത്തിൽ നിൽക്കുന്നത് അതീവ സൂക്ഷ്മമായ അന്തർജ്ഞാനവും, ലളിതമായ ജീവിതരീതിയും, ആത്മീയ ഔന്നത്യവും നൽകുന്നു.',
            'en' => 'Ketu in 1st House confers piercing intuitive insight, simple personal lifestyle, and contemplative spiritual depth.',
        ],
        'Ke_H2' => [
            'ml' => 'കേതു രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ആഴത്തിലുള്ള ആത്മീയ സത്യങ്ങൾ സംസാരിക്കാനും, ധനപരമായ കാര്യങ്ങളിൽ വിവേകം പാലിക്കാനും സഹായിക്കുന്നു.',
            'en' => 'Ketu in 2nd House creates profound philosophical speech and intuitive detachment from material wealth hoarding.',
        ],
        'Ke_H3' => [
            'ml' => 'കേതു മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് ആത്മവിശ്വാസവും, പാരമ്പര്യ കലകളിലും ആയോധനകലകളിലും താല്പര്യവും, ശത്രുജയവും നൽകുന്നു.',
            'en' => 'Ketu in 3rd House reinforces quiet inner valor, technical mastery, and effortless victory over rivals.',
        ],
        'Ke_H4' => [
            'ml' => 'കേതു നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് ആത്മീയ ശാന്തതയ്ക്കായി ശാന്തമായ അന്തരീക്ഷം ആഗ്രഹിക്കാനും ഗൃഹത്തിൽ ഈശ്വരപ്രാർത്ഥന നിറയ്ക്കാനും സഹായിക്കും.',
            'en' => 'Ketu in 4th House encourages creating a sanctified, tranquil home environment conducive to spiritual meditation.',
        ],
        'Ke_H5' => [
            'ml' => 'കേതു അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് മന്ത്രസിദ്ധിയും, വേദ-ജ്യോതിഷ ശാസ്ത്രങ്ങളിൽ അഗാധമായ പാണ്ഡിത്യവും, ദൈവാനുഗ്രഹവും സമ്മാനിക്കുന്നു.',
            'en' => 'Ketu in 5th House activates brilliant esoteric intuition, mantra siddhi, and deep comprehension of Vedic sciences.',
        ],
        'Ke_H6' => [
            'ml' => 'കേതു ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് എല്ലാവിധ ശത്രുദോഷങ്ങളെയും ശമിപ്പിക്കാനും രോഗപ്രതിരോധ ശേഷി വർദ്ധിപ്പിക്കാനും സഹായിക്കുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Ketu in 6th House is highly auspicious in Upachaya, dissolving adversary machinations and ensuring strong vital immunity.',
        ],
        'Ke_H7' => [
            'ml' => 'കേതു ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ആത്മീയ ചിന്താഗതിയുള്ള പങ്കാളിയെ നൽകുന്നു. ദാമ്പത്യത്തിൽ പരസ്പര ആത്മബന്ധം ദൃഢമാക്കാൻ ശ്രദ്ധിക്കണം.',
            'en' => 'Ketu in 7th House indicates a spiritually contemplative spouse, fostering a bond rooted in transcendent companionship.',
        ],
        'Ke_H8' => [
            'ml' => 'കേതു എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ഗൂഢശാസ്ത്രങ്ങളിലും കുണ്ഡലിനീ യോഗത്തിലും ആഴത്തിലുള്ള ജ്ഞാനവും ദീർഘായുസ്സും സമ്മാനിക്കുന്നു.',
            'en' => 'Ketu in 8th House sparks profound occult mastery, yogic awakening, and effortless navigation of life transitions.',
        ],
        'Ke_H9' => [
            'ml' => 'കേതു ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് ഉയർന്ന ധർമ്മചിന്തയും, പുണ്യതീർത്ഥാടനങ്ങളും, മഹാത്മാക്കളുടെ അനുഗ്രഹവും നൽകുന്ന ഭാഗ്യയോഗമാണ്.',
            'en' => 'Ketu in 9th House inspires sacred pilgrimages, blessings of enlightened gurus, and steadfast adherence to dharma.',
        ],
        'Ke_H10' => [
            'ml' => 'കേതു പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് ആതുരസേവനം, ആത്മീയ നേതൃത്വം, അല്ലെങ്കിൽ പ്രൊഫഷണൽ രംഗത്ത് നിശബ്ദമായ വലിയ നേട്ടങ്ങൾ നൽകുന്നു.',
            'en' => 'Ketu in 10th House establishes career excellence in healthcare, advisory counseling, spiritual organizations, or research.',
        ],
        'Ke_H11' => [
            'ml' => 'കേതു പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് ആഗ്രഹങ്ങൾ നിഷ്പ്രയാസം സഫലീകരിക്കാനും അവിചാരിത ധനലാഭം നേടാനും വഴിയൊരുക്കുന്ന ഉത്തമ സ്ഥാനമാണ്.',
            'en' => 'Ketu in 11th House is exceptionally rewarding, bestowing unexpected financial gains and peaceful fulfillment of goals.',
        ],
        'Ke_H12' => [
            'ml' => 'കേതു പന്ത്രണ്ടാം ഭാവത്തിൽ മോക്ഷകാരകനാണ്. പരമോന്നത ആത്മീയ വിമോചനവും, ധ്യാനസമാധിയും, ഈശ്വരസാക്ഷാത്കാരവും സമ്മാനിക്കുന്ന പരമപവിത്രമായ സ്ഥാനമാണ്.',
            'en' => 'Ketu in 12th House is the celebrated Moksha placement, conferring serene meditative enlightenment and ultimate spiritual liberation.',
        ],

        // ---------------- GULIKA (MANDI) IN HOUSES 1 TO 12 ----------------
        'Md_H1' => [
            'ml' => 'ഗുളികൻ ലഗ്നത്തിൽ നിൽക്കുന്നത് ശാരീരികക്ഷീണം വരാതെ നോക്കാനും ഈശ്വരഭജനം മുടക്കാതിരിക്കാനും ഓർമ്മിപ്പിക്കുന്നു. ശിവ-ശാസ്താ ക്ഷേത്രദർശനം ഉത്തമം.',
            'en' => 'Gulika in 1st House counsels routine physical wellness, meditation, and regular worship of Lord Shiva or Lord Ayyappa.',
        ],
        'Md_H2' => [
            'ml' => 'ഗുളികൻ രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് വാക്ദോഷങ്ങൾ ഒഴിവാക്കാനും, സാമ്പത്തിക ഇടപാടുകളിൽ സത്യസന്ധത പാലിക്കാനും ആവശ്യപ്പെടുന്നു.',
            'en' => 'Gulika in 2nd House advises gentle, truthful speech and disciplined management of financial liabilities.',
        ],
        'Md_H3' => [
            'ml' => 'ഗുളികൻ മൂന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് അതിയായ ധൈര്യവും, തടസ്സങ്ങളെ തച്ചുടയ്ക്കാനുള്ള മനക്കരുത്തും നൽകുന്ന വളരെ അനുകൂലമായ സ്ഥാനമാണ്.',
            'en' => 'Gulika in 3rd House is considered exceptionally favorable, conferring resolute bravery, athletic stamina, and victory over opposition.',
        ],
        'Md_H4' => [
            'ml' => 'ഗുളികൻ നാലാം ഭാവത്തിൽ നിൽക്കുന്നത് ഗൃഹത്തിൽ ശാന്തി നിലനിർത്താനും മാതൃആരോഗ്യത്തിൽ ശ്രദ്ധിക്കാനും ഓർമ്മിപ്പിക്കുന്നു.',
            'en' => 'Gulika in 4th House counsels regular spiritual purification of the residence and devoted care for maternal comfort.',
        ],
        'Md_H5' => [
            'ml' => 'ഗുളികൻ അഞ്ചാം ഭാവത്തിൽ നിൽക്കുന്നത് സന്താനങ്ങളുടെ ക്ഷേമത്തിനായി വിഷ്ണുസഹസ്രനാമ ജപവും, ബുദ്ധിപരമായ ഏകാഗ്രതയും ശീലമാക്കാൻ നിർദ്ദേശിക്കുന്നു.',
            'en' => 'Gulika in 5th House recommends recitation of Vishnu Sahasranama for child welfare and steady intellectual focus.',
        ],
        'Md_H6' => [
            'ml' => 'ഗുളികൻ ആറാം ഭാവത്തിൽ നിൽക്കുന്നത് ശത്രുദോഷങ്ങളെയും രോഗങ്ങളെയും നിഷ്പ്രഭമാക്കാൻ സഹായിക്കുന്ന അതിവിശിഷ്ടമായ സ്ഥാനമാണ്.',
            'en' => 'Gulika in 6th House is highly praised in Kerala astrology, completely vanquishing secret enemies and subduing debilities.',
        ],
        'Md_H7' => [
            'ml' => 'ഗുളികൻ ഏഴാം ഭാവത്തിൽ നിൽക്കുന്നത് ദാമ്പത്യത്തിൽ പരസ്പര വിട്ടുവീഴ്ചകളും, പങ്കാളിയോട് തുറന്ന സ്നേഹവും നിലനിർത്താൻ നിർദ്ദേശിക്കുന്നു.',
            'en' => 'Gulika in 7th House emphasizes mutual patience, transparent affection, and shared spiritual prayers in marital life.',
        ],
        'Md_H8' => [
            'ml' => 'ഗുളികൻ എട്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് ആയുർബലത്തിനായി മൃത്യുഞ്ജയ ജപവും, ആരോഗ്യപരമായ മുൻകരുതലുകളും ശീലമാക്കാൻ ഉപദേശിക്കുന്നു.',
            'en' => 'Gulika in 8th House recommends Mrityunjaya Japa, healthy lifestyle routines, and mindfulness during travel.',
        ],
        'Md_H9' => [
            'ml' => 'ഗുളികൻ ഒമ്പതാം ഭാവത്തിൽ നിൽക്കുന്നത് പിതൃപ്രീതികരമായ കർമ്മങ്ങളും, കുലദൈവ പ്രാർത്ഥനയും മുടങ്ങാതെ നടത്താൻ ഓർമ്മിപ്പിക്കുന്നു.',
            'en' => 'Gulika in 9th House counsels regular homage to ancestral lineage and faithful prayers to family deities (Kula Devata).',
        ],
        'Md_H10' => [
            'ml' => 'ഗുളികൻ പത്താം ഭാവത്തിൽ നിൽക്കുന്നത് തൊഴിൽപരമായ പ്രതിബന്ധങ്ങളെ സമർത്ഥമായി മറികടന്ന് സ്വന്തം കർമ്മരംഗത്ത് വ്യക്തിമുദ്ര പതിപ്പിക്കാൻ സഹായിക്കും.',
            'en' => 'Gulika in 10th House rewards persistent labor, overcoming occupational hurdles to build a steady professional reputation.',
        ],
        'Md_H11' => [
            'ml' => 'ഗുളികൻ പതിനൊന്നാം ഭാവത്തിൽ നിൽക്കുന്നത് വൻ സാമ്പത്തിക ലാഭവും, സർവ്വവിധ അഭീഷ്ടസിദ്ധിയും നൽകുന്ന പരമോന്നത സ്ഥാനമാണ്.',
            'en' => 'Gulika in 11th House is heralded as immensely prosperous in Kerala canons, multiplying material revenues and fulfilling desires.',
        ],
        'Md_H12' => [
            'ml' => 'ഗുളികൻ പന്ത്രണ്ടാം ഭാവത്തിൽ നിൽക്കുന്നത് അനാവശ്യ ചെലവുകൾ നിയന്ത്രിക്കാനും ആത്മീയ ദാനധർമ്മങ്ങൾ ശീലമാക്കാനും നിർദ്ദേശിക്കുന്നു.',
            'en' => 'Gulika in 12th House advises financial prudence against leakage, directing resources toward righteous charitable offerings.',
        ],
    ];
}

