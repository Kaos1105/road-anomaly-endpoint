<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $access_count;
 * @property int $hour;
 * @property int $id
 * @property int $employee_id
 * @property int $system_id
 * @property string $action
 * @property string $result_classification
 * @property string|null $accessible_type
 * @property int|null $accessible_id
 * @property string|null $message
 * @property string|null $access_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $accessible
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\System $system
 * @method static \Database\Factories\AccessHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereAccessAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereAccessibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereAccessibleType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereResultClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessHistory whereSystemId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAccessHistory {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $system_id
 * @property int $permission_1
 * @property int $permission_2
 * @property int $permission_3
 * @property int $permission_4
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\System $system
 * @method static \Database\Factories\AccessPermissionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission query()
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission wherePermission1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission wherePermission2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission wherePermission3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission wherePermission4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AccessPermission whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAccessPermission {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $system_id
 * @property int|null $display_id
 * @property int $announcement_classification
 * @property string $title
 * @property string|null $content
 * @property string $start_time
 * @property string|null $end_time
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Display|null $display
 * @property-read \App\Models\System $system
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereAnnouncementClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereDisplayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Announcement whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnnouncement {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $question_id
 * @property int $display_order
 * @property int|null $width_size
 * @property-read \App\Models\AttachmentFile|null $attachmentFile
 * @property-read \App\Models\Question|null $question
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerFile whereWidthSize($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnswerFile {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $question_id
 * @property int $display_order
 * @property string|null $answer_content
 * @property-read \App\Models\Question|null $question
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText query()
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText whereAnswerContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AnswerText whereQuestionId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAnswerText {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $attachable_type
 * @property int $attachable_id
 * @property string $file_name
 * @property string $file_path
 * @property int|null $created_by
 * @property string|null $created_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attachable
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereAttachableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereAttachableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttachmentFile whereId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAttachmentFile {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int|null $employee_id
 * @property string $action
 * @property string|null $message
 * @property string $authen_at
 * @property-read \App\Models\Employee|null $employee
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory whereAuthenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AuthenticationHistory whereMessage($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperAuthenticationHistory {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $signing_at
 * @property int $counterparty_id
 * @property int|null $counterparty_contractor_id
 * @property int|null $counterparty_representative_id
 * @property int $site_id
 * @property int $contractor_id
 * @property int $representative_id
 * @property string|null $no
 * @property string $name
 * @property int $approval_flag
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractCondition> $contractConditions
 * @property-read int|null $contract_conditions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractWorkplace> $contractWorkplaces
 * @property-read int|null $contract_workplaces_count
 * @property-read \App\Models\Employee $contractor
 * @property-read \App\Models\Site $counterparty
 * @property-read \App\Models\Employee|null $counterpartyContractor
 * @property-read \App\Models\Employee|null $counterpartyRepresentative
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\IndividualContract> $individualContracts
 * @property-read int|null $individual_contracts_count
 * @property-read \App\Models\Employee $representative
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereApprovalFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCounterpartyContractorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCounterpartyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCounterpartyRepresentativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereRepresentativeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereSigningAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BasicContract whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperBasicContract {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $chat_thread_id
 * @property int $employee_id
 * @property int $chat_classification
 * @property string|null $chat_text
 * @property \Illuminate\Support\Carbon $chat_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatNotification> $chatNotifications
 * @property-read int|null $chat_notifications_count
 * @property-read \App\Models\ChatThread $chatThread
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereChatAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereChatClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereChatText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereChatThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatContent whereId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperChatContent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $chat_thread_id
 * @property int $chat_content_id
 * @property int $employee_id
 * @property int $read_flag
 * @property \Illuminate\Support\Carbon|null $read_at
 * @property-read \App\Models\ChatContent $chatContent
 * @property-read \App\Models\ChatThread $chatThread
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereChatContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereChatThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereReadAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatNotification whereReadFlag($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperChatNotification {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $creator_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatContent> $chatContents
 * @property-read int|null $chat_contents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatNotification> $chatNotifications
 * @property-read int|null $chat_notifications_count
 * @property-read \App\Models\Employee $creator
 * @method static \Illuminate\Database\Eloquent\Builder|ChatThread newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatThread newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatThread query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChatThread whereCreatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChatThread whereId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperChatThread {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $client_site_id
 * @property string|null $role
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NegotiationEmployee> $negotiable
 * @property-read int|null $negotiable_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereClientSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientEmployee whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperClientEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $management_department_id
 * @property int $site_id
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientEmployee> $clientEmployees
 * @property-read int|null $client_employees_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Negotiation> $negotiations
 * @property-read int|null $negotiations_count
 * @property-read \App\Models\Site $site
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereManagementDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientSite whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperClientSite {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property int $id
 * @property string|null $code
 * @property string $long_name
 * @property string|null $short_name
 * @property string|null $kana
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $company_classification
 * @property string|null $group_name
 * @property string|null $previous_name
 * @property int $previous_name_flg
 * @property string|null $en_notation
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Site|null $siteRepresentative
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Site> $sites
 * @property-read int|null $sites_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCompanyClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEnNotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePreviousName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company wherePreviousNameFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Company whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCompany {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $company_id
 * @property string $date
 * @property int|null $calendar_classification
 * @property string|null $calendar_contents
 * @property int|null $work_classification
 * @property-read \App\Models\Company $company
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar query()
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereCalendarClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereCalendarContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CompanyCalendar whereWorkClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCompanyCalendar {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $display_id
 * @property string $no
 * @property int $classification
 * @property string $name
 * @property int $permission_1
 * @property int $permission_2
 * @property int $permission_3
 * @property int $permission_4
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Display|null $display
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Content newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Content query()
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDisplayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePermission1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePermission2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePermission3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content wherePermission4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Content whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $basic_contract_id
 * @property int $condition_classification
 * @property string $code
 * @property string $content
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BasicContract $basicContract
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereBasicContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereConditionClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractCondition whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContractCondition {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $notification_classification
 * @property int $notification_range
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereNotificationClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereNotificationRange($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractUserSetting whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContractUserSetting {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $basic_contract_id
 * @property int $division_id
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BasicContract $basicContract
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Division $division
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereBasicContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContractWorkplace whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperContractWorkplace {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $display_transfer_id
 * @property int $responsible_id
 * @property string $category_name
 * @property int $processing_site
 * @property int $accounting_company
 * @property int $accounting_department_id
 * @property int $address_classification
 * @property int $address_printing_1
 * @property int $address_printing_2
 * @property int $address_printing_3
 * @property int $address_printing_4
 * @property int $address_printing_5
 * @property int $address_printing_6
 * @property int $address_printing_7
 * @property string|null $specified_post_code
 * @property string|null $specified_address_1
 * @property string|null $specified_address_2
 * @property string|null $specified_address_3
 * @property string|null $specified_phone
 * @property string|null $update_order
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department|null $accountingDepartment
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Transfer|null $displayTransfer
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\Employee|null $responsibleEmployee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialData> $socialData
 * @property-read int|null $social_data_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAccountingCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAccountingDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAddressPrinting7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCategoryName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereDisplayTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereProcessingSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereResponsibleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSpecifiedAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSpecifiedAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSpecifiedAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSpecifiedPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereSpecifiedPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdateOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCustomer {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $group_id
 * @property string $name
 * @property-read \App\Models\ManagementGroup|null $managementGroup
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCategory whereName($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperCustomerCategory {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $date
 * @property int|null $work_classification
 * @property-read \App\Models\Employee $employee
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DailySchedule whereWorkClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDailySchedule {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property-read int|null $suppliers_count
 * @property int $id
 * @property int $site_id
 * @property string|null $code
 * @property string $long_name
 * @property string|null $short_name
 * @property string|null $kana
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $represent_flg
 * @property int $department_classification
 * @property string|null $previous_name
 * @property int $previous_name_flg
 * @property string|null $en_notation
 * @property string|null $phone
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customers
 * @property-read int|null $customers_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Division> $divisions
 * @property-read int|null $divisions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementDepartment> $managementDepartments
 * @property-read int|null $management_departments_count
 * @property-read \App\Models\Site $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\DepartmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDepartmentClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereEnNotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department wherePreviousName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department wherePreviousNameFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereRepresentFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDepartment {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $name
 * @property string|null $device_information
 * @property string|null $device_token
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation query()
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereDeviceInformation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereDeviceToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DeviceInformation whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDeviceInformation {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $system_id
 * @property string $code
 * @property string $name
 * @property int $display_classification
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Announcement> $announcements
 * @property-read int|null $announcements_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Content> $contents
 * @property-read int|null $contents_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Question> $questions
 * @property-read int|null $questions_count
 * @property-read \App\Models\System $system
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Display newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Display newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Display query()
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereDisplayClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Display whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDisplay {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property int $id
 * @property int $department_id
 * @property string|null $code
 * @property string $long_name
 * @property string|null $short_name
 * @property string|null $kana
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $represent_flg
 * @property int $division_classification
 * @property string|null $previous_name
 * @property int $previous_name_flg
 * @property string|null $en_notation
 * @property string|null $phone
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContractWorkplace> $contractWorkplaces
 * @property-read int|null $contract_workplaces_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\DivisionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereDivisionClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereEnNotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division wherePreviousName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division wherePreviousNameFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereRepresentFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperDivision {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property-read int|null $customer_count
 * @property-read int|null $customerResponsive_count
 * @property-read int|null $managementGroupPreparatoryPersonnel_count
 * @property-read int|null $managementGroupApplicant_count
 * @property-read int|null $managementGroupApprover_count
 * @property-read int|null $managementGroupFinalDecisionMaker_count
 * @property-read int|null $managementGroupOrderingPersonnel_count
 * @property-read int|null $managementGroupPaymentPersonnel_count
 * @property-read int|null $managementGroupCompletionPersonnel_count
 * @property-read int|null $supplierPerson_count
 * @property-read int|null $supplierCompanyPerson_count
 * @property int $id
 * @property string|null $code
 * @property string $last_name
 * @property string $first_name
 * @property string|null $kana
 * @property string|null $day_of_birth
 * @property string|null $day_of_death
 * @property int $period_accuracy_flg
 * @property int $employees_classification
 * @property string|null $maiden_name
 * @property int $previous_name_flg
 * @property int $gender
 * @property string|null $en_notation
 * @property string|null $company_email
 * @property string|null $company_phone
 * @property string|null $post_code
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $address_3
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $biography
 * @property string|null $update_history
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AccessHistory> $accessHistories
 * @property-read int|null $access_histories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AccessPermission> $accessPermissions
 * @property-read int|null $access_permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChatThread> $chatThreads
 * @property-read int|null $chat_threads_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClientEmployee> $clientEmployees
 * @property-read int|null $client_employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $contractor
 * @property-read int|null $contractor_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $counterpartyContractor
 * @property-read int|null $counterparty_contractor_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $counterpartyRepresentative
 * @property-read int|null $counterparty_representative_count
 * @property-read Employee|null $createdBy
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customerResponsive
 * @property-read int|null $customer_responsive_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Login> $logins
 * @property-read int|null $logins_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementDepartmentEmployee> $managementDepartmentEmployees
 * @property-read int|null $management_department_employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupApplicant
 * @property-read int|null $management_group_applicant_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupApprover
 * @property-read int|null $management_group_approver_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupCompletionPersonnel
 * @property-read int|null $management_group_completion_personnel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupFinalDecisionMaker
 * @property-read int|null $management_group_final_decision_maker_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupOrderingPersonnel
 * @property-read int|null $management_group_ordering_personnel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupPaymentPersonnel
 * @property-read int|null $management_group_payment_personnel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementGroup> $managementGroupPreparatoryPersonnel
 * @property-read int|null $management_group_preparatory_personnel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $representative
 * @property-read int|null $representative_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $supplierCompanyPerson
 * @property-read int|null $supplier_company_person_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $supplierPerson
 * @property-read int|null $supplier_person_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\System> $systems
 * @property-read int|null $systems_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Transfer> $transfers
 * @property-read int|null $transfers_count
 * @property-read Employee|null $updatedBy
 * @method static \Database\Factories\EmployeeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereBiography($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDayOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDayOfDeath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmployeesClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEnNotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMaidenName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePeriodAccuracyFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee wherePreviousNameFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdateHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $operation_rule
 * @property string|null $social_criteria
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialEvent> $socialEvents
 * @property-read int|null $social_events_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\EventClassificationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereOperationRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereSocialCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventClassification whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperEventClassification {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $facility_group_id
 * @property int $responsible_user_id
 * @property string|null $usage_method
 * @property string $name
 * @property int $facility_classification
 * @property int $aggregation_classification
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\FacilityGroup $facilityGroup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reservation> $reservations
 * @property-read int|null $reservations_count
 * @property-read \App\Models\Employee $responsibleUser
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Facility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility query()
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereAggregationClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereFacilityClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereFacilityGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereResponsibleUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereUsageMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Facility whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFacility {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $use_group_id
 * @property string $name
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Facility> $facilities
 * @property-read int|null $facilities_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @property-read \App\Models\Group $useGroup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FacilityUserSetting> $userSettings
 * @property-read int|null $user_settings_count
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereUseClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityGroup whereUseGroupId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFacilityGroup {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $holiday_display
 * @property int $facility_group_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\FacilityGroup $facilityGroup
 * @property-read \App\Models\Employee|null $updatedBy
 * @property-read \App\Models\Employee $user
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereFacilityGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereHolidayDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FacilityUserSetting whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFacilityUserSetting {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $favorable_type
 * @property int $favorable_id
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favorable
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereFavorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Favorite whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperFavorite {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FacilityGroup> $facilityGroup
 * @property-read int|null $facility_group_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupEmployee> $groupEmployees
 * @property-read int|null $group_employees_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroup {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $group_id
 * @property int $employee_id
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Group $group
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|GroupEmployee whereId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGroupEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $basic_contract_id
 * @property string $start_date
 * @property string $end_date
 * @property string $name
 * @property float $unit_price
 * @property int $unit_classification
 * @property string|null $unit_name
 * @property int $rounding_method
 * @property int $display_order
 * @property int $use_classification
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\BasicContract $basicContract
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract query()
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereBasicContractId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereRoundingMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUnitClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUnitName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndividualContract whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperIndividualContract {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $system_id
 * @property string $content_no
 * @property string $block
 * @property int $block_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\System $system
 * @method static \Illuminate\Database\Eloquent\Builder|Layout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Layout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Layout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereBlock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereBlockOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereContentNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereSystemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Layout whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLayout {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $login_id
 * @property string $password
 * @property string|null $password_decrypt
 * @property string|null $password_updated_at
 * @property string|null $authen_at
 * @property int|null $authen_flag
 * @property string|null $previous_login_at
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalAccessToken> $personalAccessTokens
 * @property-read int|null $personal_access_tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\LoginFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Login newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Login newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Login query()
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereAuthenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereAuthenFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login wherePasswordDecrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login wherePasswordUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login wherePreviousLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Login whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperLogin {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $department_id
 * @property string $name
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Department $department
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MyCompanyEmployee> $myCompanyEmployees
 * @property-read int|null $my_company_employees_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartment whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperManagementDepartment {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $management_department_id
 * @property int $my_company_employee_id
 * @property-read \App\Models\MyCompanyEmployee $myCompanyEmployee
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee whereManagementDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementDepartmentEmployee whereMyCompanyEmployeeId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperManagementDepartmentEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string|null $sender_post_code
 * @property string|null $sender_address_1
 * @property string|null $sender_address_2
 * @property string|null $sender_address_3
 * @property string|null $sender_name
 * @property string|null $contact_point
 * @property string|null $contact_phone
 * @property int $preparatory_personnel_id
 * @property int $applicant_id
 * @property int $approver_id
 * @property int $final_decision_maker_id
 * @property int $ordering_personnel_id
 * @property int $payment_personnel_id
 * @property int $completion_personnel_id
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $applicant
 * @property-read \App\Models\Employee|null $approver
 * @property-read \App\Models\Employee|null $completionPersonnel
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CustomerCategory> $customerCategories
 * @property-read int|null $customer_categories_count
 * @property-read \App\Models\Employee|null $finalDecisionMaker
 * @property-read \App\Models\Employee|null $orderingPersonnel
 * @property-read \App\Models\Employee|null $paymentPersonnel
 * @property-read \App\Models\Employee|null $preparatoryPersonnel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialEvent> $socialEvents
 * @property-read int|null $social_events_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereApplicantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereApproverId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereCompletionPersonnelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereContactPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereFinalDecisionMakerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereOrderingPersonnelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup wherePaymentPersonnelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup wherePreparatoryPersonnelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereSenderAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereSenderAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereSenderAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereSenderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereSenderPostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ManagementGroup whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperManagementGroup {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property int $position_classification
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ManagementDepartment> $managementDepartments
 * @property-read int|null $management_departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NegotiationEmployee> $negotiable
 * @property-read int|null $negotiable_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee wherePositionClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MyCompanyEmployee whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperMyCompanyEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $client_site_id
 * @property string $date_time
 * @property int $progress_classification
 * @property string|null $purpose
 * @property string|null $result
 * @property string|null $manager_comment
 * @property int|null $like_counter
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $manager_comment_by
 * @property string|null $manager_comment_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\ClientSite $clientSite
 * @property-read \App\Models\Employee|null $commentBy
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\ManagementDepartment|null $managementDepartment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NegotiationEmployee> $participants
 * @property-read int|null $participants_count
 * @property-read \App\Models\Site|null $site
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereClientSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereLikeCounter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereManagerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereManagerCommentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereManagerCommentBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereProgressClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Negotiation whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNegotiation {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $negotiation_id
 * @property string $negotiable_type
 * @property int $negotiable_id
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $negotiable
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee query()
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee whereNegotiableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee whereNegotiableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NegotiationEmployee whereNegotiationId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperNegotiationEmployee {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property array|null $abilities
 * @property \Illuminate\Support\Carbon|null $last_used_at
 * @property \Illuminate\Support\Carbon|null $expires_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $expired_inactivity_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $tokenable
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereAbilities($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereExpiredInactivityAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereLastUsedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereTokenableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PersonalAccessToken whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperPersonalAccessToken {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $supplier_id
 * @property int $product_classification
 * @property string|null $code
 * @property string $name
 * @property float|null $unit_price
 * @property int $tax_classification_1
 * @property int $tax_classification_2
 * @property int $tax_classification_3
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Site|null $site
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialData> $socialData
 * @property-read int|null $social_data_count
 * @property-read \App\Models\Supplier|null $supplier
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProductClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSupplierId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxClassification1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxClassification2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTaxClassification3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperProduct {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $display_id
 * @property string $code
 * @property string $classification
 * @property string $title
 * @property int $permission_2
 * @property int $permission_3
 * @property int $permission_4
 * @property int|null $similar_faq_1_id
 * @property int|null $similar_faq_2_id
 * @property int|null $similar_faq_3_id
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerFile> $answerFiles
 * @property-read int|null $answer_files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AnswerText> $answerTexts
 * @property-read int|null $answer_texts_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Display|null $display
 * @property-read Question|null $similarFaq1
 * @property-read Question|null $similarFaq2
 * @property-read Question|null $similarFaq3
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDisplayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePermission2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePermission3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question wherePermission4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSimilarFaq1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSimilarFaq2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereSimilarFaq3Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Question whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperQuestion {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $facility_id
 * @property string|null $reservation_date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $work_contents
 * @property int $use_person_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Facility $facility
 * @property-read \App\Models\Employee|null $updatedBy
 * @property-read \App\Models\Employee $usePerson
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereFacilityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereReservationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUsePersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereWorkContents($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperReservation {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $employeeFavorites
 * @property-read int|null $employee_favorites_count
 * @property int $id
 * @property int $company_id
 * @property string|null $code
 * @property string $long_name
 * @property string|null $short_name
 * @property string|null $kana
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $represent_flg
 * @property int $site_classification
 * @property string|null $previous_name
 * @property int $previous_name_flg
 * @property string|null $en_notation
 * @property string|null $post_code
 * @property string|null $address_1
 * @property string|null $address_2
 * @property string|null $address_3
 * @property string|null $phone
 * @property string|null $area_name
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttachmentFile> $attachmentFiles
 * @property-read int|null $attachment_files_count
 * @property-read \App\Models\ClientSite|null $clientSite
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $counterparty
 * @property-read int|null $counterparty_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Department> $departments
 * @property-read int|null $departments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Employee> $employees
 * @property-read int|null $employees_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Favorite> $favorites
 * @property-read int|null $favorites_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BasicContract> $ourSiteContract
 * @property-read int|null $our_site_contract_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Supplier> $suppliers
 * @property-read int|null $suppliers_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\SiteFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Site newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Site query()
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAddress3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereAreaName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereEnNotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePostCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePreviousName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site wherePreviousNameFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereRepresentFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereShortName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereSiteClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Site whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSite {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $social_event_id
 * @property int $customer_id
 * @property int $display_transfer_id
 * @property int|null $product_id
 * @property string|null $product_name
 * @property float|null $unit_price
 * @property float|null $discount
 * @property int $tax_classification_1
 * @property float|null $tax_1
 * @property float|null $shipping_cost
 * @property int $tax_classification_2
 * @property float|null $tax_2
 * @property float|null $other
 * @property int $tax_classification_3
 * @property float|null $tax_3
 * @property float|null $total_amount
 * @property float|null $total_tax
 * @property string|null $purpose
 * @property string|null $result
 * @property int $processing_site
 * @property int $accounting_company
 * @property int $accounting_department_id
 * @property int $address_classification
 * @property int $data_progress
 * @property string|null $comment_history
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Department|null $accountingDepartment
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\Transfer|null $displayTransfer
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\SocialEvent|null $socialEvent
 * @property-read \App\Models\Employee|null $updatedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Workflow> $workflows
 * @property-read int|null $workflows_count
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereAccountingCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereAccountingDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereAddressClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereCommentHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereDataProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereDisplayTransferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereOther($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereProcessingSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereProductName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData wherePurpose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereSocialEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTax1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTax2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTax3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTaxClassification1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTaxClassification2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTaxClassification3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereTotalTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSocialData {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $group_id
 * @property int $event_id
 * @property string $event_title
 * @property int $event_progress
 * @property string $planned_start
 * @property string $creation_deadline
 * @property string $approval_deadline
 * @property string $order_deadline
 * @property string $planned_completion
 * @property string|null $plan_comment
 * @property string|null $actual_comment
 * @property string|null $memo
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\EventClassification|null $eventClassification
 * @property-read \App\Models\ManagementGroup|null $managementGroup
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SocialData> $socialData
 * @property-read int|null $social_data_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\SocialEventFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereActualComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereApprovalDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereCreationDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereEventProgress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereEventTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereOrderDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent wherePlanComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent wherePlannedCompletion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent wherePlannedStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialEvent whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSocialEvent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $sales_store_id
 * @property int $supplier_classification
 * @property int $supplier_person_id
 * @property int $my_company_person_id
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company|null $company
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Employee|null $myCompanyPerson
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @property-read \App\Models\Site|null $salesStore
 * @property-read \App\Models\Employee|null $supplierPerson
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\SupplierFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier query()
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereMyCompanyPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSalesStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSupplierClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereSupplierPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Supplier whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSupplier {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string|null $overview
 * @property string $start_date
 * @property string|null $end_date
 * @property int $default_permission_2
 * @property int $default_permission_3
 * @property int $default_permission_4
 * @property string|null $memo
 * @property int $display_order
 * @property int $use_classification
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AccessPermission> $accessPermissions
 * @property-read int|null $access_permissions_count
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Display> $displays
 * @property-read int|null $displays_count
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\SystemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|System newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|System newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|System query()
 * @method static \Illuminate\Database\Eloquent\Builder|System whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereDefaultPermission2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereDefaultPermission3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereDefaultPermission4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|System whereUseClassification($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperSystem {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $date
 * @property string|null $start_time
 * @property string|null $end_time
 * @property string|null $work_contents
 * @property string|null $work_place
 * @property int|null $public_classification
 * @property int|null $public_group_id
 * @property int|null $updated_by
 * @property string|null $updated_at
 * @property-read \App\Models\CompanyCalendar|null $companyCalendar
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Group|null $group
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule wherePublicClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule wherePublicGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereWorkContents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TimeSchedule whereWorkPlace($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTimeSchedule {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read int $customer_count
 * @property int $id
 * @property int $company_id
 * @property int|null $site_id
 * @property int|null $department_id
 * @property int|null $division_id
 * @property int $employee_id
 * @property string|null $team_name
 * @property string|null $position
 * @property int|null $contract_classification
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $represent_flg
 * @property int $transfer_classification
 * @property int $major_history_flg
 * @property string|null $memo
 * @property int $display_order
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\Employee|null $createdBy
 * @property-read \App\Models\Customer|null $customer
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\Division|null $division
 * @property-read \App\Models\Employee $employee
 * @property-read \App\Models\Site|null $site
 * @property-read \App\Models\Employee|null $updatedBy
 * @method static \Database\Factories\TransferFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereContractClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereMajorHistoryFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereRepresentFlg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereSiteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereTeamName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereTransferClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Transfer whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperTransfer {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $employee_id
 * @property string $login_id
 * @property string $password
 * @property string|null $password_decrypt
 * @property string|null $password_updated_at
 * @property string|null $authen_at
 * @property int|null $authen_flag
 * @property string|null $previous_login_at
 * @property string|null $memo
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuthenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAuthenFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLoginId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordDecrypt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePasswordUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePreviousLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedBy($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $display_employee_id
 * @property int $display_order
 * @property int|null $display_weekly_classification
 * @property-read \App\Models\Employee $displayEmployee
 * @property-read \App\Models\Employee $user
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule whereDisplayEmployeeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule whereDisplayWeeklyClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|WeeklySchedule whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWeeklySchedule {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $social_data_id
 * @property int $workflow_order
 * @property int $scheduled_person_id
 * @property int|null $executor_id
 * @property int $execution_type
 * @property \Illuminate\Support\Carbon|null $execution_at
 * @property-read \App\Models\Employee|null $executor
 * @property-read \App\Models\Employee|null $scheduledPerson
 * @property-read \App\Models\SocialData|null $socialData
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow query()
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereExecutionAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereExecutionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereExecutorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereScheduledPersonId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereSocialDataId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Workflow whereWorkflowOrder($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperWorkflow {}
}

