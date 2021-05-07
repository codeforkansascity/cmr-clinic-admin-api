<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeTrafficStatutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cmr:make-traffic-stautes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $records = $this->getStatutes();

        foreach ($records AS $record) {
            $record = json_decode(json_encode($record), true);

            $this->getOrAddStatute(
                $record['section'],
                $record['name']
            );
        }

        return 0;
    }

    private function getOrAddStatute($section, $name) {
        
    }

    private function getStatutes()
    {
        $var = <<< EOM
        [
        {"section": "304.001","name": "Definitions for chapter 304 and chapter 307."},
        {"section": "304.005","name": "Autocycle — defined—protective headgear not required — valid driver's license required to operate."},
        {"section": "304.009","name": "Speed limit — violation, penalty."},
        {"section": "304.010","name": "Definitions — maximum speed limits — cities, towns, villages, certain counties, may set speed limit, how set — slower speeds set, when — violations, penalty."},
        {"section": "304.011","name": "Slow speed, regulation of — agricultural implements, slower speeds, when, special permits required — penalties."},
        {"section": "304.012","name": "Motorists to exercise highest degree of care — violation, penalty."},
        {"section": "304.013","name": "All-terrain vehicles, prohibited on highways, rivers or streams of this state, exceptions, operational requirements — special permits — prohibited uses — penalty."},
        {"section": "304.014","name": "Rules of the road to be observed."},
        {"section": "304.015","name": "Drive on right of highway — traffic lanes — signs — violations, penalties."},
        {"section": "304.016","name": "Passing regulations — violations, penalties."},
        {"section": "304.017","name": "Distance at which vehicle must follow, penalty."},
        {"section": "304.019","name": "Hand and mechanical signals, violations, penalty."},
        {"section": "304.022","name": "Emergency and stationary vehicles — use of lights and sirens — right-of-way — procedure — penalty."},
        {"section": "304.023","name": "Passing stopped streetcars, penalty."},
        {"section": "304.024","name": "Crosswalks and parking regulations established — signs — violation, an infraction."},
        {"section": "304.025","name": "Highway and vehicle defined."},
        {"section": "304.027","name": "Spinal cord injury fund created, uses — surcharge imposed, when."},
        {"section": "304.028","name": "Brain injury fund created, moneys in fund, uses — surcharge imposed, when."},
        {"section": "304.029","name": "Operation of low-speed vehicles on highway, permitted when — exemptions."},
        {"section": "304.030","name": "Certain buses and trucks to stop at railroad crossing, when — exception, requirements."},
        {"section": "304.031","name": "Traffic signal preemption system, use of, permitted when — violations, penalty."},
        {"section": "304.032","name": "Utility vehicles, operation on highway and in streams or rivers prohibited — exceptions — passengers prohibited — violations, penalty."},
        {"section": "304.033","name": "Recreational off-highway vehicles, operation on highways prohibited, exceptions — operation within streams and rivers prohibited, exceptions — license required for operation, exception."},
        {"section": "304.034","name": "Municipalities may regulate golf cart and motorized wheelchair usage on streets and highways."},
        {"section": "304.035","name": "Stop required at railroad grade crossing, when — commercial motor vehicles, speed at crossings — penalty."},
        {"section": "304.040","name": "Failure to stop, penalty."},
        {"section": "304.044","name": "Buses and trucks not to follow within three hundred feet — penalty."},
        {"section": "304.050","name": "School buses, drivers to stop for, when — signs required on buses — crossing control arm — bus driver responsibilities — driver identity rebuttable presumption, when (Jessica's Law)."},
        {"section": "304.060","name": "School buses and other district vehicles, use to be regulated by board — field trips in common carriers, regulation authorized — violation by employee, effect — design of school buses, regulated by board — St. Louis County buses may use word special."},
        {"section": "304.070","name": "Violation of section 304.050, penalty."},
        {"section": "304.075","name": "School bus signs to be removed, when — misdemeanor."},
        {"section": "304.076","name": "Head Start buses to bear signs."},
        {"section": "304.079","name": "Use of designated disabled parking spaces, when."},
        {"section": "304.080","name": "Handicapped persons with white cane or dog, driver to take all necessary precautions — cane or dog not required to enforce rights, when."},
        {"section": "304.110","name": "Violation of sections 304.080 to 304.110, penalty."},
        {"section": "304.120","name": "Municipal regulations — owner or lessor not liable for violations, when."},
        {"section": "304.125","name": "Traffic violation citation quota prohibited--exception."},
        {"section": "304.130","name": "Regulation of vehicular traffic — notice, hearings — approval — publication of notice (first class counties)."},
        {"section": "304.140","name": "Penalty for violations."},
        {"section": "304.151","name": "Driver's responsibility not to obstruct traffic — written warning, infraction, effective date."},
        {"section": "304.152","name": "Roadside checkpoints and roadblock patterns based on vehicle type prohibited."},
        {"section": "304.153","name": "Tow companies or tow lists, utilization of by law enforcement and state transportation employees—definitions—requirements—unauthorized towing, penalty—inapplicability."},
        {"section": "304.154","name": "Towing truck company requirements—access to towed vehicles by insurance adjusters—notice to vehicle owner of transfer from storage lot or facility—display of tow company address, when."},
        {"section": "304.155","name": "Abandoned motor vehicles on public property, removal — hazards on land and water, removal, limited liability, when — towing of property report to highway or water patrol or crime inquiry and inspection report when, owner liable for costs — check for stolen vehicles procedure — reclaiming vehicle — lien for charges — record maintenance by towing companies — lienholder repossession, procedure."},
        {"section": "304.156","name": "Notice to towing company, owner or lienholder, when — storage charges, when authorized — search of vehicle for ownership documents — petition, determination of wrongful taking — possessory lien, new title, how issued — sale of abandoned property by municipality or county — towing company, new title when."},
        {"section": "304.157","name": "Vehicles left unattended or improperly parked on private property of another, procedure for removal and disposition — violation of certain required procedure, penalty."},
        {"section": "304.158","name": "Notice to owner of abandoned property — duty of real property owner — liability of towing company — recovery for damages to real property, when — liability of real property owner for towing charges, when — information to be displayed on wrecker — towing charges — storage facility charges, method of payment — authorization of real property owner to tow, violation, penalty — ordinances specifying charges — violations of towing laws, penalties."},
        {"section": "304.159","name": "Municipality may prohibit storage of certain vehicles, exceptions."},
        {"section": "304.160","name": "Glass, tacks, injurious substances, duty to remove from highway, when — penalty."},
        {"section": "304.170","name": "Regulations as to width, height and length of vehicles — inapplicability, when — implements of husbandry defined — sludge disposal units."},
        {"section": "304.172","name": "Fire-fighting equipment exempt from size restrictions."},
        {"section": "304.174","name": "Size and load restrictions not applicable to wreckers, tow trucks, rollbacks and car carriers, when."},
        {"section": "304.180","name": "Regulations as to weight — axle load, tandem axle defined — transport of specific items, total gross weight permitted — requirements during disasters — emergency vehicles, maximum gross weight — natural gas fueled vehicles, increase in maximum gross weight, when."},
        {"section": "304.181","name": "Buses, axle weight limits."},
        {"section": "304.184","name": "Transportation of solid waste, weight restrictions for trucks and tractor-trailers."},
        {"section": "304.190","name": "Height and weight regulations (cities of 75,000 or more) — commercial zone defined."},
        {"section": "304.200","name": "Special permits for oversize or overweight loads — rules for issuing — when valid."},
        {"section": "304.210","name": "Reduction of maximum weight by highways and transportation commission — notice."},
        {"section": "304.220","name": "Weight limits on county roads and bridges reduced, when — penalty for violation."},
        {"section": "304.230","name": "Enforcement of load laws — commercial vehicle inspectors, powers."},
        {"section": "304.232","name": "Municipal law enforcement officers, state highway patrol to approve certification procedures — fees — requirements — random roadside inspections prohibited, when — rulemaking authority."},
        {"section": "304.235","name": "Commercial vehicles licensed for eighteen thousand pounds or less not to stop at weigh station or be otherwise identified — confidentiality rules do not apply to commercial vehicle enforcement officers, when — penalty for evading weigh station."},
        {"section": "304.240","name": "Violation of load law a misdemeanor — penalty."},
        {"section": "304.250","name": "Restriction on use of metal-tired vehicles — penalty."},
        {"section": "304.260","name": "Tractors exempt — designation of truck routes by commission."},
        {"section": "304.271","name": "Observance of traffic-control devices — presumptions — penalty."},
        {"section": "304.281","name": "Rules for traffic where controlled by light signals — right turn on red light, when — violations, penalty."},
        {"section": "304.285","name": "Red light violations by motorcycles or bicycles, affirmative defense, when."},
        {"section": "304.289","name": "Timing of signals, minimum interval times to be established."},
        {"section": "304.291","name": "Rules for pedestrians controlled by special signs."},
        {"section": "304.301","name": "Rules for vehicular traffic controlled by flashing signals — violation, penalty."},
        {"section": "304.311","name": "Observance of lane — direction — control signals."},
        {"section": "304.321","name": "Unauthorized signal devices prohibited — trafficway not to be used for signs — nuisances declared."},
        {"section": "304.331","name": "Alteration or removal of traffic-control devices prohibited."},
        {"section": "304.341","name": "Turns at intersection — violation, penalty."},
        {"section": "304.351","name": "Right-of-way at intersection — signs at intersections — violation, penalty — additional penalties — definitions — order of suspension, contents, appeal."},
        {"section": "304.361","name": "Penalty for violation of sections 304.271 to 304.351."},
        {"section": "304.373","name": "Hazardous materials, requirements for transportation — violations, penalties."},
        {"section": "304.570","name": "Penalty for violations."},
        {"section": "304.58","name": "Definitions."},
        {"section": "304.582","name": "Fines for moving violations — fines for violations in work or construction zones — signs required for assessing fines — penalty for passing in work or construction zones — not applicable to court costs."},
        {"section": "304.585","name": "Endangerment of a highway worker defined — fine, points assessed — aggravated endangerment of a highway worker, fine, points assessed — offense not applicable in absence of workers in zone — no citation or conviction, when — revocation of driver's license, when."},
        {"section": "304.590","name": "Travel safe zone defined — doubling of fine for violation in — signage required."},
        {"section": "304.665","name": "Riding in open bed of truck prohibited, when, exceptions, penalty."},
        {"section": "304.670","name": "Collection and maintenance of certain information regarding traffic law enforcement, analyses to be conducted."},
        {"section": "304.678","name": "Distance to be maintained when overtaking a bicycle — violation, penalty."},
        {"section": "304.705","name": "Certain trucks not to drive in far left lane of certain interstate highways (St. Charles and Jefferson counties)."},
        {"section": "304.725","name": "Veterans displaying special license plates or certain military medal recipients may park without charge in metered parking — windshield placard for veterans and certain military medal recipients — exceptions."},
        {"section": "304.820","name": "Text messaging and using a hand-held mobile device while operating a motor vehicle prohibited, when — exceptions — definitions — violation, penalty."},
        {"section": "304.890","name": "Definitions."},
        {"section": "304.892","name": "Violations, penalties."},
        {"section": "304.894","name": "Offense of endangerment of an emergency responder, elements — penalties — revocation of driver's license, when."},
        {"section": "307.005","name": "Light-emitting diodes deemed operating properly, when."},
        {"section": "307.010","name": "Loads which might become dislodged to be secured — failure, penalty."},
        {"section": "307.015","name": "Mud flaps required, certain motor vehicles — violation, penalty."},
        {"section": "307.020","name": "Definitions."},
        {"section": "307.025","name": "Exemptions."},
        {"section": "307.030","name": "Approval of lighting equipment — rules and regulations — fee — revocation or suspension of certificate, rulemaking procedure."},
        {"section": "307.035","name": "Director's decisions final, when — appeal to board — hearing and decisions."},
        {"section": "307.040","name": "When lights required — violation, penalty."},
        {"section": "307.045","name": "Headlamp on motor vehicles — violations, penalty."},
        {"section": "307.050","name": "Headlamps — permissible substitutes, speed limit."},
        {"section": "307.055","name": "Single-beam headlamps — intensity, adjustment — violation, penalty."},
        {"section": "307.060","name": "Multiple-beam headlamps — arrangement — violation, penalty."},
        {"section": "307.065","name": "New vehicles shall have beam indicator — violation, penalty."},
        {"section": "307.070","name": "Dimming of lights, when — violation, penalty."},
        {"section": "307.075","name": "Taillamps, reflectors — violations, penalty."},
        {"section": "307.080","name": "Auxiliary lamps — number — location — violation, penalty."},
        {"section": "307.085","name": "Cowl, fender, running board and backup lamps — violation, penalty."},
        {"section": "307.090","name": "Spotlamps — restrictions, penalty."},
        {"section": "307.095","name": "Colors of various lamps — restriction of red lights, penalty."},
        {"section": "307.100","name": "Limitations on lamps other than headlamps — flashing signals prohibited except on specified vehicles — penalty."},
        {"section": "307.105","name": "Limitation on total of lamps lighted at one time — violation, penalty."},
        {"section": "307.110","name": "Parked vehicles — how lighted — exception — violation, penalty."},
        {"section": "307.115","name": "Other vehicles — how lighted — violation, penalty."},
        {"section": "307.120","name": "Penalty for violations."},
        {"section": "307.122","name": "Electronic message devices, prohibited on vehicle, exceptions — penalty."},
        {"section": "307.125","name": "Animal-driven vehicles, lighting requirements — penalty — rulemaking authority."},
        {"section": "307.127","name": "Slow-moving equipment, emblem required on, when — emblem described — violation, penalty — alternative display, reflective material."},
        {"section": "307.128","name": "Motorcycle headlamp modulation permitted, when — labeling requirements — auxiliary lighting."},
        {"section": "307.130","name": "Safety glass defined."},
        {"section": "307.135","name": "Director not to license vehicle without safety glass."},
        {"section": "307.140","name": "Safety glass on vehicles for hire and school buses."},
        {"section": "307.145","name": "Sale of vehicles without safety glass prohibited."},
        {"section": "307.150","name": "List of approved glass."},
        {"section": "307.155","name": "Violation a misdemeanor."},
        {"section": "307.160","name": "Revocation of permit by public service commission."},
        {"section": "307.165","name": "Seat safety belts standard equipment, when — penalty."},
        {"section": "307.170","name": "Other equipment of motor vehicles — violations, penalty."},
        {"section": "307.171","name": "Studded tires, prohibited when — penalty."},
        {"section": "307.172","name": "Altering passenger motor vehicle by raising front or rear of vehicle prohibited, when — bumpers front and rear required, when, exemptions — violations not to pass inspection — penalty."},
        {"section": "307.173","name": "Specifications for sun-screening device applied to windshield or windows — permit required, when — exceptions — rules, procedure — violations, penalty."},
        {"section": "307.175","name": "Sirens and flashing lights, use of, when — permits — violation, penalty."},
        {"section": "307.177","name": "Transporting hazardous materials, equipment required — federal physical requirements not applicable, when — violations, penalty."},
        {"section": "307.178","name": "Seat belts required for passenger cars — passenger cars defined — exceptions — failure to comply, effect on evidence and damages, admissible as evidence, when — penalty — passengers in car exceeding number of seat belts not violation for failure to use."},
        {"section": "307.179","name": "Definitions — transporting children under sixteen years of age, restraint systems — penalty — exceptions — program of public information."},
        {"section": "307.180","name": "Bicycle and motorized bicycle, defined."},
        {"section": "307.183","name": "Brakes required."},
        {"section": "307.185","name": "Lights and reflectors, when required — standards to be met."},
        {"section": "307.188","name": "Rights and duties of bicycle and motorized bicycle riders."},
        {"section": "307.190","name": "Riding to right, required for bicycles and motorized bicycles."},
        {"section": "307.191","name": "Bicycle to operate on the shoulder adjacent to roadway, when — roadway defined."},
        {"section": "307.192","name": "Bicycle required to give hand or mechanical signals."},
        {"section": "307.193","name": "Penalty for violation."},
        {"section": "307.195","name": "License required — operation on interstate highway prohibited — violation, penalty."},
        {"section": "307.196","name": "Equipment required."},
        {"section": "307.198","name": "All-terrain vehicles, equipment required — penalty."},
        {"section": "307.205","name": "Defined — requirements for operation."},
        {"section": "307.207","name": "Equipment required."},
        {"section": "307.209","name": "Roadway operation, requirements."},
        {"section": "307.211","name": "Violations, penalties."},
        {"section": "307.250","name": "Compact — entered into."},
        {"section": "307.255","name": "Legislative findings."},
        {"section": "307.260","name": "Rules not effective until approved by legislature."},
        {"section": "307.265","name": "Director of revenue to be state's commissioner."},
        {"section": "307.270","name": "State employees retirement system may agree with commission on coverage of employees."},
        {"section": "307.275","name": "State agencies to cooperate with commission."},
        {"section": "307.280","name": "Documents to be filed with secretary of state."},
        {"section": "307.285","name": "Commission to submit budget to commissioner of administration."},
        {"section": "307.290","name": "State auditor may inspect commission's accounts."},
        {"section": "307.295","name": "Executive head defined."},
        {"section": "307.350","name": "Motor vehicles, biennial inspection required, exceptions — authorization to operate vehicle to inspection station for inspection — violation, penalty."},
        {"section": "307.353","name": "No safety inspection required during registration period which exceeds two years."},
        {"section": "307.355","name": "Current inspection required for registration or transfer, exception — inspection valid, how long."},
        {"section": "307.360","name": "Permits and instructions furnished by superintendent — items to be inspected — inspection stations, permit fee, permit renewal — application contents — mechanic's examination — revocation of permits, hearing on."},
        {"section": "307.365","name": "Inspection station permit not transferable — approval to be on official form — report to superintendent — defects, correction of, who may make — inspection fee — sticker fee — inspection fund, created, purpose — discontinuation of station, procedures."},
        {"section": "307.370","name": "Prohibited acts."},
        {"section": "307.375","name": "Inspection of school buses — items covered — violations, when corrected, notice to patrol — spot checks authorized."},
        {"section": "307.380","name": "Accidents, reinspection required when — certain sales exempt from inspection requirement — violation, penalty."},
        {"section": "307.385","name": "Director of revenue to suspend registration of unapproved vehicle on written notice of superintendent."},
        {"section": "307.390","name": "Penalty for violation — superintendent of highway patrol may assign persons to enforce inspections laws."},
        {"section": "307.400","name": "Commercial vehicles, equipment and operation, regulations, exceptions — violations, penalty — rulemaking authority."}
        ]
EOM;


        return json_decode($var);

    }
}
